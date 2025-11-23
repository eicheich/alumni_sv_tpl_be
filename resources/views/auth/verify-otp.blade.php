@extends('layouts.guest')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md bg-white shadow-lg rounded-xl">
            <div class="p-6 md:p-8">
                <!-- Title -->
                <h2 class="text-2xl font-semibold text-center mb-2">Verifikasi OTP</h2>
                <p class="text-center text-gray-500 mb-6">Kami telah mengirimkan kode OTP ke email Anda</p>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('alumni.verify-otp') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-1">
                            Kode OTP <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="otp_code" name="otp_code"
                            class="w-full text-center px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                            placeholder="000000" maxlength="6" pattern="[0-9]{6}" inputmode="numeric"
                            value="{{ old('otp_code') }}" required>

                        <p class="text-xs text-gray-500 mt-2">
                            Masukkan kode 6 digit yang telah dikirim ke email Anda
                        </p>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-medium transition">
                        Verifikasi OTP
                    </button>
                </form>

                <!-- Back & Resend -->
                <div class="text-center mt-6">
                    <p class="text-gray-600 text-sm mb-2">Belum menerima kode OTP?</p>
                    <a href="{{ route('alumni.validate-data.view') }}"
                        class="text-indigo-500 hover:underline font-medium text-sm">
                        Kembali dan kirim ulang
                    </a>
                </div>

                <hr class="my-6 border-gray-200">

                <!-- Tips -->
                <div class="bg-blue-50 border border-blue-300 text-blue-800 px-4 py-3 rounded-lg text-sm">
                    <strong class="font-medium">Tips:</strong>
                    <p class="mt-1">
                        Kode OTP berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapa pun.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
