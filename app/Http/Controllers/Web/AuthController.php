<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\AlumniOtp;
use App\Mail\AlumniOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerAdminView()
    {
        return view('auth.register-admin');
    }
    public function registerAdmin(Request $request)
    {
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
            $admin = Admin::create([
                'role' => 'admin',
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

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login.view')->with('success', 'Logged out successfully.');
    }

    public function alumniValidateDataView()
    {
        return view('auth.register-alumni-validate-data');
    }

    public function alumniValidateData(Request $request)
    {
        $credentials = $request->only('email', 'nim');
        if (!$credentials['email'] || !$credentials['nim']) {
            return back()->withErrors(['error' => 'Email and NIM are required.'])->withInput();
        }
        $user = User::where('email', $credentials['email'])
            ->whereHas('alumni', function ($q) use ($credentials) {
                $q->where('nim', $credentials['nim'])->where('is_active', 0);
            })->first();
        if ($user) {
            // Generate 6-digit OTP
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Delete any existing OTP for this user
            AlumniOtp::where('user_id', $user->id)->delete();

            // Create new OTP with 10 minutes expiration
            $otp = AlumniOtp::create([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(10),
                'is_verified' => false,
            ]);

            // Send OTP email
            try {
                Mail::to($user->email)->send(new AlumniOtpMail($user->name, $otpCode));
            } catch (\Exception $e) {
                Log::error('OTP Email Error: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Gagal mengirim OTP ke email. Pastikan email Anda valid atau coba lagi nanti.'])->withInput();
            }

            // Store user_id and email in session for OTP verification
            session([
                'alumni_otp_user_id' => $user->id,
                'alumni_otp_email' => $user->email,
            ]);

            return redirect()->route('alumni.verify-otp.view')->with('success', 'OTP has been sent to your email.');
        }
        $activeUser = User::where('email', $credentials['email'])
            ->whereHas('alumni', function ($q) {
                $q->where('is_active', 1);
            })->first();
        if ($activeUser) {
            return back()->withErrors(['error' => 'This account is already active. Please login.'])->withInput();
        }
        return back()->withErrors(['email' => 'Invalid email or NIM.'])->withInput();
    }

    public function alumniRegisterView1()
    {
        return view('auth.register-alumni');
    }

    public function alumniVerifyOtpView()
    {
        if (!session('alumni_otp_user_id')) {
            return redirect()->route('alumni.validate-data.view')->withErrors(['error' => 'Please enter your email and NIM first.']);
        }
        return view('auth.verify-otp');
    }

    public function alumniVerifyOtp(Request $request)
    {
        $userId = session('alumni_otp_user_id');
        if (!$userId) {
            return back()->withErrors(['error' => 'Session expired. Please try again.']);
        }

        $request->validate([
            'otp_code' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ], [
            'otp_code.required' => 'OTP code is required.',
            'otp_code.size' => 'OTP code must be 6 digits.',
            'otp_code.regex' => 'OTP code must contain only numbers.',
        ]);

        $otp = AlumniOtp::where('user_id', $userId)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Invalid OTP code.'])->withInput();
        }

        if ($otp->isExpired()) {
            return back()->withErrors(['otp_code' => 'OTP has expired. Please request a new one.'])->withInput();
        }

        // Mark OTP as verified
        $otp->update(['is_verified' => true]);

        // Store user_id in session for profile completion
        session(['alumni_verified_user_id' => $userId]);

        return redirect()->route('alumni.complete-profile.view')->with('success', 'OTP verified successfully. Please complete your profile.');
    }

    public function alumniCompleteProfileView()
    {
        if (!session('alumni_verified_user_id')) {
            return redirect()->route('alumni.validate-data.view')->withErrors(['error' => 'Please complete the OTP verification first.']);
        }
        return view('auth.complete-profile');
    }

    public function alumniCompleteProfile(Request $request)
    {
        $userId = session('alumni_verified_user_id');
        if (!$userId) {
            return redirect()->route('alumni.validate-data.view')->withErrors(['error' => 'Session expired. Please try again.']);
        }

        // Validate input
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'phone.required' => 'Phone number is required.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);

            // Update user password and phone
            $user->update([
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
            ]);

            // Update alumni profile
            $alumni = $user->alumni;
            if ($alumni) {
                $alumni->update([
                    'is_active' => 1, // Activate account
                ]);
            }

            DB::commit();

            // Clear sessions
            session()->forget(['alumni_otp_user_id', 'alumni_otp_email', 'alumni_verified_user_id']);

            return redirect()->route('alumni.registration-success')->with('success', 'Registration completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Complete Profile Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to complete registration. Please try again.'])->withInput();
        }
    }

    public function alumniRegistrationSuccess()
    {
        return view('auth.registration-success');
    }

    public function alumniLoginView()
    {
        return view('auth.login-alumni');
    }

    public function alumniLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate with alumni guard
        if (Auth::guard('alumni')->attempt($credentials)) {
            return redirect()->route('alumni.dashboard.index')->with('success', 'Login successful.');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function alumniForgetPasswordView()
    {
        return view('auth.forgot-password');
    }

    public function alumniForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.exists' => 'Email not found in our system.',
        ]);

        $user = User::where('email', $request->email)
            ->whereHas('alumni', function ($q) {
                $q->where('is_active', 1);
            })->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered as an active alumni account.'])->withInput();
        }

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing OTP for this user
        AlumniOtp::where('user_id', $user->id)->delete();

        // Create new OTP with 10 minutes expiration
        $otp = AlumniOtp::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_verified' => false,
        ]);

        // Send OTP email
        try {
            Mail::to($user->email)->send(new AlumniOtpMail($user->name, $otpCode));
        } catch (\Exception $e) {
            Log::error('OTP Email Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal mengirim OTP ke email. Pastikan email Anda valid atau coba lagi nanti.'])->withInput();
        }

        // Store user_id in session for OTP verification
        session([
            'forgot_password_user_id' => $user->id,
            'forgot_password_email' => $user->email,
        ]);

        return redirect()->route('alumni.verify-forgot-password-otp-view')->with('success', 'OTP has been sent to your email.');
    }

    public function alumniVerifyForgotPasswordOtpView()
    {
        if (!session('forgot_password_user_id')) {
            return redirect()->route('alumni.forgot-password-view')->withErrors(['error' => 'Please enter your email first.']);
        }
        return view('auth.verify-forgot-password-otp');
    }

    public function alumniVerifyForgotPasswordOtp(Request $request)
    {
        $userId = session('forgot_password_user_id');
        if (!$userId) {
            return back()->withErrors(['error' => 'Session expired. Please try again.']);
        }

        $request->validate([
            'otp_code' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ], [
            'otp_code.required' => 'OTP code is required.',
            'otp_code.size' => 'OTP code must be 6 digits.',
            'otp_code.regex' => 'OTP code must contain only numbers.',
        ]);

        $otp = AlumniOtp::where('user_id', $userId)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Invalid OTP code.'])->withInput();
        }

        if ($otp->isExpired()) {
            return back()->withErrors(['otp_code' => 'OTP has expired. Please request a new one.'])->withInput();
        }

        // Mark OTP as verified
        $otp->update(['is_verified' => true]);

        // Store user_id in session for password reset
        session(['forgot_password_verified_user_id' => $userId]);

        return redirect()->route('alumni.reset-password-view')->with('success', 'OTP verified successfully. Please set your new password.');
    }

    public function alumniResetPasswordView()
    {
        if (!session('forgot_password_verified_user_id')) {
            return redirect()->route('alumni.forgot-password-view')->withErrors(['error' => 'Please complete the OTP verification first.']);
        }
        return view('auth.reset-password');
    }

    public function alumniResetPassword(Request $request)
    {
        $userId = session('forgot_password_verified_user_id');
        if (!$userId) {
            return redirect()->route('alumni.forgot-password-view')->withErrors(['error' => 'Session expired. Please try again.']);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);

            // Update user password
            $user->update([
                'password' => bcrypt($validated['password']),
            ]);

            DB::commit();

            // Clear sessions
            session()->forget(['forgot_password_user_id', 'forgot_password_email', 'forgot_password_verified_user_id']);

            return redirect()->route('alumni.login.view')->with('success', 'Password reset successful. Please login with your new password.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reset Password Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to reset password. Please try again.'])->withInput();
        }
    }
}
