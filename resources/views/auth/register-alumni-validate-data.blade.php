@extends('layouts.guest')

@section('title', 'Register Alumni')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-6xl overflow-hidden bg-white shadow-lg rounded-lg">

            <!-- Bagian Kiri: Form -->
            <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Daftar</h2>
                <p class="text-sm text-gray-500 mb-8">
                    Mohon masukkan Email dan NIM IPB, data akan divalidasi sesuai dengan database prodi
                </p>

                <form class="space-y-6" action="{{ route('alumni.validate-data') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('email') border-red-500 @enderror"
                            id="email" name="email" placeholder="nama@example.com" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                        <input type="text"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('nim') border-red-500 @enderror"
                            id="nim" name="nim" placeholder="Contoh: j04xxxxx" value="{{ old('nim') }}"
                            required>
                        @error('nim')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        Daftar
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 mb-2">Sudah punya akun?</p>
                    <a href="{{ route('alumni.login.view') }}"
                        class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                        Masuk di sini
                    </a>
                </div>
            </div>

            <!-- Bagian Kanan: Gambar -->
            <div class="hidden lg:block lg:w-1/2 relative">
                <img src="{{ asset('resources/images/cover.jpg') }}" alt="Kampus IPB" class="object-cover w-full h-full">
            </div>
        </div>
    </div>

@endsection
