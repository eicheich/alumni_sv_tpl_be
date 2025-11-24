@extends('layouts.guest')

@section('title', 'Registrasi Berhasil')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-12 text-center">

            <!-- Icon -->
            <div class="mb-6 flex justify-center">
                <div class="rounded-full bg-green-100 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">Registrasi Berhasil!</h2>

            <p class="text-gray-600 mb-8">
                Selamat! Akun alumni Anda telah berhasil dibuat dan diaktifkan.
                Anda sekarang dapat masuk menggunakan email dan password yang telah Anda buat.
            </p>

            <!-- Success Alert -->
            <div class="mb-8 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-left">
                <p class="text-sm font-medium">✓ Profil Anda telah diperbarui</p>
                <p class="text-sm mt-1">Nomor telepon dan password telah tersimpan dengan aman.</p>
            </div>

            <!-- Button -->
            <a href="{{ route('login.view') }}"
                class="block w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg text-sm font-medium transition">
                Masuk ke Akun Saya
            </a>

            <!-- Back link -->
            <div class="mt-6">
                <p class="text-sm text-gray-500">
                    Kembali ke
                    <a href="{{ route('index') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                        halaman utama
                    </a>
                </p>
            </div>

        </div>
    </div>

@endsection
