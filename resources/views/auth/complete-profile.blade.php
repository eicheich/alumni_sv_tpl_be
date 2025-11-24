@extends('layouts.guest')

@section('title', 'Lengkapi Profile Alumni')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-6xl overflow-hidden bg-white shadow-lg rounded-lg">

            <!-- Bagian Kiri: Form -->
            <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Lengkapi Profile Anda</h2>
                <p class="text-sm text-gray-500 mb-8">
                    Atur password dan informasi profile untuk menyelesaikan pendaftaran
                </p>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('alumni.complete-profile') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            Password harus mengandung kombinasi huruf besar, kecil, angka, dan simbol
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Ulangi password" required>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('phone') border-red-500 @enderror"
                            placeholder="Contoh: 08123456789" value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        Selesaikan Pendaftaran
                    </button>
                </form>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg text-sm mt-6">
                    <strong class="font-medium">Catatan:</strong>
                    <p class="mt-1">
                        Semua field yang ditandai dengan asterisk (*) harus diisi untuk menyelesaikan pendaftaran.
                    </p>
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
