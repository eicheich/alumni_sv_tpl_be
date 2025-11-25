<?php

namespace App\Http\Controllers\Web\Alumni;

use App\Http\Controllers\Controller;
use App\Models\EducationalBackground;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('alumni.profile');
    }

    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'photo_profile.required' => 'Foto profil wajib dipilih',
            'photo_profile.image' => 'File harus berupa gambar',
            'photo_profile.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'photo_profile.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $user = auth('alumni')->user();

        // Delete old photo if exists
        if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
            Storage::disk('public')->delete($user->photo_profile);
        }

        // Store new photo
        $path = $request->file('photo_profile')->store('profile-photos', 'public');

        // Update user photo_profile
        DB::table('users')->where('id', $user->id)->update([
            'photo_profile' => $path,
        ]);

        Log::info('Profile photo uploaded', ['user_id' => $user->id]);

        return redirect()->route('alumni.profile')->with('success', 'Foto profil berhasil diupload');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth('alumni')->user()->id,
            'phone' => 'nullable|string|max:20',
            'nim' => 'required|string|max:50',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'nim.required' => 'NIM wajib diisi',
            'birthdate.date' => 'Format tanggal lahir tidak valid',
            'gender.in' => 'Jenis kelamin tidak valid',
        ]);

        $user = auth('alumni')->user();
        $alumni = $user->alumni;

        DB::transaction(function () use ($request, $user, $alumni) {
            // Update user data
            DB::table('users')->where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update alumni data
            $alumni->update([
                'nim' => $request->nim,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
            ]);
        });

        Log::info('Profile updated', ['user_id' => $user->id]);

        return redirect()->route('alumni.profile')->with('success', 'Data diri berhasil diperbarui');
    }

    public function changePasswordView()
    {
        return view('alumni.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = auth('alumni')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai'])->withInput();
        }

        // Update password
        DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        Log::info('Alumni changed password', ['user_id' => $user->id]);

        return redirect()->route('alumni.profile')->with('success', 'Password berhasil diubah');
    }

    public function storeEducationalBackground(Request $request)
    {
        $request->validate([
            'institution_name' => 'required|string',
            'degree' => 'required|string',
            'entry_year' => 'required|integer|min:1900|max:' . date('Y'),
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'major' => 'nullable|string',
            'faculty' => 'nullable|string',
        ], [
            'institution_name.required' => 'Nama institusi wajib diisi',
            'degree.required' => 'Gelar/Program wajib diisi',
            'entry_year.required' => 'Tahun masuk wajib diisi',
            'graduation_year.required' => 'Tahun lulus wajib diisi',
        ]);

        $alumni = auth('alumni')->user()->alumni;

        EducationalBackground::create([
            'alumni_id' => $alumni->id,
            'institution_name' => $request->institution_name,
            'degree' => $request->degree,
            'entry_year' => $request->entry_year,
            'graduation_year' => $request->graduation_year,
            'major' => $request->major,
            'faculty' => $request->faculty,
        ]);

        Log::info('Educational background created', ['alumni_id' => $alumni->id]);
        return redirect()->route('alumni.profile')->with('success', 'Latar belakang pendidikan berhasil ditambahkan');
    }

    public function editEducationalBackground($id)
    {
        $educationalBackground = EducationalBackground::findOrFail($id);

        // Check ownership
        if ($educationalBackground->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        return view('alumni.educational-backgrounds.edit', compact('educationalBackground'));
    }

    public function updateEducationalBackground(Request $request, $id)
    {
        $request->validate([
            'institution_name' => 'required|string',
            'degree' => 'required|string',
            'entry_year' => 'required|integer|min:1900|max:' . date('Y'),
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'major' => 'nullable|string',
            'faculty' => 'nullable|string',
        ], [
            'institution_name.required' => 'Nama institusi wajib diisi',
            'degree.required' => 'Gelar/Program wajib diisi',
            'entry_year.required' => 'Tahun masuk wajib diisi',
            'graduation_year.required' => 'Tahun lulus wajib diisi',
        ]);

        $educationalBackground = EducationalBackground::findOrFail($id);

        // Check ownership
        if ($educationalBackground->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        $educationalBackground->update([
            'institution_name' => $request->institution_name,
            'degree' => $request->degree,
            'entry_year' => $request->entry_year,
            'graduation_year' => $request->graduation_year,
            'major' => $request->major,
            'faculty' => $request->faculty,
        ]);

        Log::info('Educational background updated', ['id' => $id]);
        return redirect()->route('alumni.profile')->with('success', 'Latar belakang pendidikan berhasil diperbarui');
    }

    public function destroyEducationalBackground($id)
    {
        $educationalBackground = EducationalBackground::findOrFail($id);

        // Check ownership
        if ($educationalBackground->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        $educationalBackground->delete();
        Log::info('Educational background deleted', ['id' => $id]);
        return back()->with('success', 'Latar belakang pendidikan berhasil dihapus');
    }

    public function storeCareer(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'position' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'position.required' => 'Posisi wajib diisi',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai',
        ]);

        $alumni = auth('alumni')->user()->alumni;
        Career::create([
            'alumni_id' => $alumni->id,
            'company_name' => $request->company_name,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        Log::info('Career created', ['alumni_id' => $alumni->id]);
        return redirect()->route('alumni.profile')->with('success', 'Data karir berhasil ditambahkan');
    }

    public function editCareer($id)
    {
        $career = Career::findOrFail($id);

        // Check ownership
        if ($career->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        return view('alumni.careers.edit', compact('career'));
    }

    public function updateCareer(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string',
            'position' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'position.required' => 'Posisi wajib diisi',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai',
        ]);

        $career = Career::findOrFail($id);

        // Check ownership
        if ($career->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        $career->update([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        Log::info('Career updated', ['id' => $id]);
        return redirect()->route('alumni.profile')->with('success', 'Data karir berhasil diperbarui');
    }

    public function destroyCareer($id)
    {
        $career = Career::findOrFail($id);

        // Check ownership
        if ($career->alumni->user_id !== auth('alumni')->user()->id) {
            abort(403);
        }

        $career->delete();
        Log::info('Career deleted', ['id' => $id]);
        return back()->with('success', 'Data karir berhasil dihapus');
    }
}
