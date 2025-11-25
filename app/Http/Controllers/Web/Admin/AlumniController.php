<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\EducationalBackground;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Validation\Rule;

class AlumniController extends Controller
{
    /**
     * Export alumni data to CSV with customizable fields.
     */
    public function exportExcel(Request $request)
    {
        // Validate selected fields
        $request->validate([
            'fields' => 'required|array|min:1|max:20',
            'fields.*' => 'required|string|in:no,nama,nim,angkatan,email,jurusan,jenis_kelamin,tanggal_lahir,tahun_lulus,status_aktivasi'
        ], [
            'fields.required' => 'Pilih minimal 1 kolom untuk diekspor.',
            'fields.min' => 'Pilih minimal 1 kolom untuk diekspor.',
            'fields.*.required' => 'Kolom yang dipilih tidak boleh kosong.',
            'fields.*.in' => 'Kolom yang dipilih tidak valid.'
        ]);

        $selectedFields = $request->fields;
        $alumni = Alumni::with('user', 'major')->get();
        $fileName = 'data_alumni_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($alumni, $selectedFields) {
            $handle = fopen('php://output', 'w');

            // Create header row based on selected fields
            $headerRow = [];
            $fieldLabels = [
                'no' => 'No',
                'nama' => 'Nama',
                'nim' => 'NIM',
                'angkatan' => 'Angkatan',
                'email' => 'Email',
                'jurusan' => 'Jurusan',
                'jenis_kelamin' => 'Jenis Kelamin',
                'tanggal_lahir' => 'Tanggal Lahir',
                'tahun_lulus' => 'Tahun Lulus',
                'status_aktivasi' => 'Status Aktivasi'
            ];

            foreach ($selectedFields as $field) {
                $headerRow[] = $fieldLabels[$field] ?? $field;
            }
            fputcsv($handle, $headerRow);

            // Create data rows based on selected fields
            foreach ($alumni as $key => $alumnus) {
                $row = [];
                foreach ($selectedFields as $field) {
                    switch ($field) {
                        case 'no':
                            $row[] = $key + 1;
                            break;
                        case 'nama':
                            $row[] = $alumnus->user->name ?? '';
                            break;
                        case 'nim':
                            $row[] = $alumnus->nim;
                            break;
                        case 'angkatan':
                            $row[] = $alumnus->angkatan ?? '';
                            break;
                        case 'email':
                            $row[] = $alumnus->user->email ?? '';
                            break;
                        case 'jurusan':
                            $row[] = $alumnus->major->name ?? '';
                            break;
                        case 'jenis_kelamin':
                            $row[] = match ($alumnus->gender) {
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                                default => ''
                            };
                            break;
                        case 'tanggal_lahir':
                            $row[] = $alumnus->birthdate ? \Carbon\Carbon::parse($alumnus->birthdate)->format('d/m/Y') : '';
                            break;
                        case 'tahun_lulus':
                            $row[] = $alumnus->educationalBackgrounds->first()->graduation_year ?? '';
                            break;
                        case 'status_aktivasi':
                            $row[] = $alumnus->is_active ? 'Sudah Aktivasi' : 'Belum Aktivasi';
                            break;
                        default:
                            $row[] = '';
                    }
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Alumni::with('user', 'major')->whereHas('user')->whereHas('major');

        // Search by name, email, or NIM
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('nim', 'like', "%{$search}%");
        }

        // Filter by major
        if ($request->has('major_id') && $request->major_id) {
            $query->where('major_id', $request->major_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', (bool)$request->status);
        }

        // Filter by angkatan
        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        $alumni = $query->paginate(10);
        $majors = Major::all();
        $angkatans = Alumni::distinct()->pluck('angkatan')->sort();

        return view('admin.alumni.index', compact('alumni', 'majors', 'angkatans'));
    }


    public function addAlumni(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'major_id' => 'required|exists:majors,id',
            'nim' => 'required|string|max:50|unique:alumnis',
            'angkatan' => 'required|string|max:10',
            'graduation_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'photo_profile' => 'nullable|image|max:2048',
            'generation' => 'nullable|integer',
            'gender' => 'nullable|in:L,P',
        ]);
        // entry year = angkatan + 1963
        $entry_year = (int)$request->angkatan + 1963;
        if (!$validate) {
            return back()->withErrors($validate)->withInput();
        }
        // prsess image
        $photoPath = null;
        if ($request->hasFile('photo_profile')) {
            $photoPath = $request->file('photo_profile')->store('photo_profiles', 'public');
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'photo_profile' => $photoPath,
                'password' => bcrypt('temporarypassword'),
            ]);
            Alumni::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'angkatan' => $request->angkatan,
                'major_id' => $request->major_id,
                'gender' => $request->gender,
                'is_active' => false,
            ]);
            EducationalBackground::create([
                'alumni_id' => $user->alumni->id,
                'generation' => $request->generation,
                'institution_name' => 'IPB University',
                'major' => 'Teknologi Rekayasa Perangkat Lunak',
                'entry_year' => $entry_year,
                'graduation_year' => $request->graduation_year,
                'degree' => 'Diploma 4',
                'faculty' => 'Sekolah Vokasi',
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add alumni: ' . $e->getMessage()])->withInput();
        }
        return redirect()->route('admin.alumni.index')->with('success', 'Alumni added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try {
            $id = decrypt($encrypted_id);
            $alumni = Alumni::with(['user', 'major', 'career', 'educationalBackgrounds'])->findOrFail($id);
            return view('admin.alumni.show', compact('alumni'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'ID alumni tidak valid atau telah kedaluwarsa.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'Terjadi kesalahan saat mengakses data alumni.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encrypted_id)
    {
        try {
            $id = decrypt($encrypted_id);
            $alumni = Alumni::with(['user', 'major', 'educationalBackgrounds'])->findOrFail($id);
            $majors = Major::all();
            return view('admin.alumni.edit', compact('alumni', 'majors'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'ID alumni tidak valid atau telah kedaluwarsa.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'Terjadi kesalahan saat mengakses data alumni.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encrypted_id)
    {
        try {
            $id = decrypt($encrypted_id);
            // Get alumni record
            $alumni = Alumni::findOrFail($id);

            // Get current user data
            $user = User::find($alumni->user_id);

            // Build base rules with NO unique constraints
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'nim' => 'required|string|max:50',
                'angkatan' => 'required|string|max:10',
                'graduation_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
                'birthdate' => 'nullable|date',
                'gender' => 'nullable|in:L,P',
                'major_id' => 'required|exists:majors,id',
                'photo_profile' => 'nullable|image|max:2048',
            ];

            // Validate without uniqueness first
            $validated = $request->validate($rules);

            // NOW check uniqueness manually if values changed
            $requestNim = (string)$request->nim;
            $currentNim = (string)($alumni->nim ?? '');

            $requestEmail = (string)$request->email;
            $currentEmail = (string)($user?->email ?? '');

            // Check if NIM changed and already exists elsewhere
            if ($requestNim !== $currentNim) {
                $nimExists = Alumni::where('nim', $requestNim)->where('id', '!=', $alumni->id)->exists();
                if ($nimExists) {
                    return back()->withErrors(['nim' => 'The nim has already been taken.'])->withInput();
                }
            }

            // Check if Email changed and already exists elsewhere
            if ($requestEmail !== $currentEmail && $user) {
                $emailExists = User::where('email', $requestEmail)->where('id', '!=', $user->id)->exists();
                if ($emailExists) {
                    return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
                }
            }

            DB::beginTransaction();
            try {
                // Update or create user if it doesn't exist
                if (!$user) {
                    $user = new User();
                    $user->id = $alumni->user_id;
                }

                $user->name = $request->name;
                $user->email = $request->email;

                // Handle photo upload
                if ($request->hasFile('photo_profile')) {
                    // Delete old photo if exists
                    if ($user->photo_profile) {
                        Storage::disk('public')->delete($user->photo_profile);
                    }
                    $user->photo_profile = $request->file('photo_profile')->store('photo_profiles', 'public');
                }
                $user->save();

                $alumni->nim = $request->nim;
                $alumni->angkatan = $request->angkatan;
                $alumni->birthdate = $request->birthdate;
                $alumni->gender = $request->gender;
                $alumni->major_id = $request->major_id;
                $alumni->save();

                // Update graduation_year in educational background if it exists
                if ($request->graduation_year) {
                    $educationalBackground = $alumni->educationalBackgrounds()->first();
                    if ($educationalBackground) {
                        $educationalBackground->graduation_year = $request->graduation_year;
                        $educationalBackground->save();
                    }
                }
                DB::commit();
                return redirect()->route('admin.alumni.show', encrypt($alumni->id))->with('success', 'Alumni berhasil diperbarui.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal memperbarui alumni: ' . $e->getMessage()])->withInput();
            }
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'ID alumni tidak valid atau telah kedaluwarsa.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data alumni.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encrypted_id)
    {
        try {
            $id = decrypt($encrypted_id);
            DB::beginTransaction();
            try {
                // Get alumni record
                $alumni = Alumni::findOrFail($id);

                // Get user associated with alumni
                $user = $alumni->user;

                // Delete photo if user exists and has photo
                if ($user && $user->photo_profile) {
                    Storage::disk('public')->delete($user->photo_profile);
                }

                // Delete all related records from alumni
                if ($alumni->career) {
                    $alumni->career()->delete();
                }
                if ($alumni->educationalBackgrounds) {
                    $alumni->educationalBackgrounds()->delete();
                }

                // Delete alumni record
                $alumni->delete();

                // Delete admin record if exists
                if ($user && $user->admin) {
                    $user->admin()->delete();
                }

                // Delete user record
                if ($user) {
                    $user->delete();
                }

                DB::commit();
                return redirect()->route('admin.alumni.index')->with('success', 'Alumni berhasil dihapus.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal menghapus alumni: ' . $e->getMessage()]);
            }
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'ID alumni tidak valid atau telah kedaluwarsa.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni.index')->withErrors(['error' => 'Terjadi kesalahan saat menghapus data alumni.']);
        }
    }
}
