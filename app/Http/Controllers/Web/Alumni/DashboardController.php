<?php

namespace App\Http\Controllers\Web\Alumni;

use App\Http\Controllers\Controller;
use App\Models\EducationalBackground;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('alumni.dashboard');
    }

    public function profile()
    {
        return view('alumni.profile');
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

    // Educational Background
    public function educationalBackgrounds()
    {
        $alumni = auth('alumni')->user()->alumni;
        $educationalBackgrounds = $alumni->educationalBackgrounds;
        return view('alumni.educational-backgrounds.index', compact('educationalBackgrounds'));
    }

    public function createEducationalBackground()
    {
        return view('alumni.educational-backgrounds.create');
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
        return redirect()->route('alumni.educational-backgrounds')->with('success', 'Latar belakang pendidikan berhasil ditambahkan');
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
        return redirect()->route('alumni.educational-backgrounds')->with('success', 'Latar belakang pendidikan berhasil diperbarui');
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

    // Career
    public function careers()
    {
        $alumni = auth('alumni')->user()->alumni;
        $careers = $alumni->career ? collect([$alumni->career]) : collect([]);
        return view('alumni.careers.index', compact('careers'));
    }

    public function createCareer()
    {
        return view('alumni.careers.create');
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

        // Delete existing career if any
        if ($alumni->career) {
            $alumni->career->delete();
        }

        Career::create([
            'alumni_id' => $alumni->id,
            'company_name' => $request->company_name,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        Log::info('Career created', ['alumni_id' => $alumni->id]);
        return redirect()->route('alumni.careers')->with('success', 'Data karir berhasil ditambahkan');
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
        return redirect()->route('alumni.careers')->with('success', 'Data karir berhasil diperbarui');
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
