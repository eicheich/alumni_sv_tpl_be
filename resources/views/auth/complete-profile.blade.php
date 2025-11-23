@extends('layouts.guest')

@section('title', 'Lengkapi Profile Alumni')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-xl">
            <div class="p-6 md:p-8">
                <!-- Title -->
                <h2 class="text-2xl font-semibold text-center mb-1">Lengkapi Profile Anda</h2>
                <p class="text-center text-gray-500 mb-6">
                    Atur password dan informasi profile untuk menyelesaikan pendaftaran
                </p>

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
                <form action="{{ route('alumni.complete-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter" required>

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2">
                            Password harus mengandung kombinasi huruf besar, kecil, angka, dan simbol
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Ulangi password" required>

                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition @error('phone') border-red-500 @enderror"
                            placeholder="Contoh: 08123456789" value="{{ old('phone') }}" required>

                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-medium transition">
                        Selesaikan Pendaftaran
                    </button>
                </form>

                <hr class="my-6 border-gray-200">

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-300 text-blue-800 px-4 py-3 rounded-lg text-sm">
                    <strong class="font-medium">Catatan:</strong>
                    <p class="mt-1">
                        Semua field yang ditandai dengan asterisk (*) harus diisi untuk menyelesaikan pendaftaran.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
