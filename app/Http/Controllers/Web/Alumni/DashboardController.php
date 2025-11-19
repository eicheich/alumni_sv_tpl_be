<?php

namespace App\Http\Controllers\Web\Alumni;

use App\Http\Controllers\Controller;
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
}
