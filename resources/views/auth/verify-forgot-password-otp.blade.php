@extends('layouts.guest')

@section('title', 'Verifikasi OTP - Reset Password')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

            <!-- Heading -->
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-2">Verifikasi OTP</h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Kami telah mengirimkan kode OTP ke email Anda untuk reset password
            </p>

                <!-- Alert Error -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('alumni.verify-forgot-password-otp') }}" method="POST">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode OTP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="otp_code" name="otp_code"
                            class="w-full text-center px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-lg tracking-widest"
                            placeholder="000000" maxlength="6" pattern="[0-9]{6}" inputmode="numeric"
                            value="{{ old('otp_code') }}" required>
                        <p class="text-xs text-gray-500 mt-2">
                            Masukkan kode 6 digit yang telah dikirim ke email Anda
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded-lg text-sm font-medium hover:bg-purple-800 transition">
                        Verifikasi OTP
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 mb-2">Belum menerima kode OTP?</p>
                    <a href="{{ route('alumni.forgot-password-view') }}"
                        class="text-purple-700 hover:text-purple-800 font-semibold text-sm">
                        Kembali dan kirim ulang
                    </a>
                </div>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg text-sm mt-6">
                    <strong class="font-medium">Tips:</strong>
                    <p class="mt-1">
                        Kode OTP berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapa pun.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
