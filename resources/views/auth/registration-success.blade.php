@extends('layouts.guest')

@section('title', 'Registrasi Berhasil')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-xl">
            <div class="p-8 text-center">

                <!-- Icon -->
                <div class="mb-5 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75l2.25 2.25L15 10.5m4.5 1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-semibold mb-3">Registrasi Berhasil!</h2>

                <p class="text-gray-600 mb-6">
                    Selamat! Akun alumni Anda telah berhasil dibuat dan diaktifkan.  
                    Anda sekarang dapat masuk menggunakan email dan password yang telah Anda buat.
                </p>

                <!-- Success Alert -->
                <div class="mb-6 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-left">
                    <p class="text-sm font-medium">✓ Profil Anda telah diperbarui</p>
                    <p class="text-sm mt-1">Nomor telepon dan password telah tersimpan dengan aman.</p>
                </div>

                <!-- Button -->
                <a href="{{ route('alumni.login.view') }}"
                    class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-medium transition">
                    Masuk ke Akun Saya
                </a>

                <!-- Back link -->
                <div class="mt-5">
                    <small class="text-gray-500">
                        Kembali ke
                        <a href="{{ route('index') }}" class="text-indigo-500 hover:underline">
                            halaman utama
                        </a>
                    </small>
                </div>

            </div>
        </div>
    </div>

@endsection
