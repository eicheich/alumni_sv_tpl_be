<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function registerAdminView()
    {
        return view('auth.register-admin');
    }
    public function registerAdmin(Request $request) {
        // validate
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if (!$validate) {
            return back()->withErrors($validate)->withInput();
        }

        // create user
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $admin=Admin::create([
                'role'=>'admin',
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }

        // redirect to login
        return redirect()->route('admin.login.view')->with('success', 'Admin registered successfully. Please login.');


    }
    public function loginAdminView()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $auth = Auth::attempt($credentials);
        if ($auth) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Login successful.');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login.view')->with('success', 'Logged out successfully.');
    }

    public function AlumniRegisterValidateEmailNimView()
    {
        return view('auth.register-alumni-validate-emailnim');
    }
}
