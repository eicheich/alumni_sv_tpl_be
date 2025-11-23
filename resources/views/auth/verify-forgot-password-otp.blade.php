@extends('layouts.guest')

@section('title', 'Verifikasi OTP - Reset Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            
            <!-- Heading -->
            <h2 class="text-2xl font-semibold text-center mb-1">Verifikasi OTP</h2>
            <p class="text-center text-gray-500 mb-6">Kami telah mengirimkan kode OTP ke email Anda</p>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 p-3 text-sm">
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('alumni.verify-forgot-password-otp') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="otp_code" class="block font-medium mb-1">
                        Kode OTP <span class="text-red-500">*</span>
                    </label>

                    <input 
                        type="text"
                        id="otp_code"
                        name="otp_code"
                        placeholder="000000"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        inputmode="numeric"
                        value="{{ old('otp_code') }}"
                        required
                        class="
                            w-full px-4 py-3 border rounded-lg text-center text-lg tracking-widest
                            focus:outline-none focus:ring-2 focus:ring-indigo-400
                        "
                    >

                    <p class="text-gray-500 text-sm mt-2">
                        Masukkan kode 6 digit yang telah dikirim ke email Anda
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 rounded-lg transition"
                >
                    Verifikasi OTP
                </button>
            </form>

            <!-- Resend Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600 mb-1">Belum menerima kode OTP?</p>
                <a href="{{ route('alumni.forgot-password-view') }}" class="text-indigo-500 font-medium hover:underline">
                    Kembali dan kirim ulang
                </a>
            </div>

            <div class="my-6 border-t"></div>

            <!-- Info Box -->
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg text-sm">
                <strong>Tips:</strong> Kode OTP akan berlaku selama 10 menit.
            </div>

        </div>
    </div>

@endsection
