@extends('layouts.guest')

@section('title', 'Login Alumni')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-6xl overflow-hidden bg-white shadow-lg rounded-lg">

            <!-- Bagian Kiri: Form -->
            <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Masuk</h2>
                <p class="text-sm text-gray-500 mb-8">
                    Masuk dengan menggunakan email IPB
                </p>

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" placeholder="contoh@apps.ipb.ac.id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('email') border-red-500 @enderror"
                            id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kata sandi</label>
                        <input type="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('password') border-red-500 @enderror"
                            id="password" name="password" placeholder="masukkan kata sandi" required>
                        @error('password')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        Masuk
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('alumni.forgot-password-view') }}"
                        class="text-sm text-purple-600 hover:text-purple-700">
                        Lupa password?
                    </a>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 mb-2">Belum punya akun?</p>
                    <a href="{{ route('alumni.validate-data.view') }}"
                        class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                        Daftar di sini
                    </a>
                </div>
            </div>

            <!-- Bagian Kanan: Gambar -->
            <div class="hidden lg:block lg:w-1/2 relative">
                <img src="{{ Vite::asset('resources/images/cover.jpg') }}" alt="Kampus IPB"
                    class="object-cover w-full h-full">
            </div>
        </div>
    </div>

@endsection
