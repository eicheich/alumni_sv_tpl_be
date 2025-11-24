@extends('layouts.guest')

@section('title', 'Verifikasi OTP')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-6xl overflow-hidden bg-white shadow-lg rounded-lg">

            <!-- Bagian Kiri: Form -->
            <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Verifikasi OTP</h2>
                <p class="text-sm text-gray-500 mb-8">
                    Kami telah mengirimkan kode OTP ke email Anda
                </p>

                <form class="space-y-6" action="{{ route('alumni.verify-otp') }}" method="POST">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode OTP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="otp_code" name="otp_code"
                            class="w-full text-center px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-lg tracking-widest"
                            placeholder="000000" maxlength="6" pattern="[0-9]{6}" inputmode="numeric"
                            value="{{ old('otp_code') }}" required>
                        <p class="text-xs text-gray-500 mt-2">
                            Masukkan kode 6 digit yang telah dikirim ke email Anda
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        Verifikasi OTP
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 mb-2">Belum menerima kode OTP?</p>
                    <a href="{{ route('alumni.validate-data.view') }}"
                        class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
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

            <!-- Bagian Kanan: Gambar -->
            <div class="hidden lg:block lg:w-1/2 relative">
                <img src="{{ asset('resources/images/cover.jpg') }}" alt="Kampus IPB" class="object-cover w-full h-full">
            </div>
        </div>
    </div>

@endsection
