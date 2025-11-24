@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

            <!-- Heading -->
            <h2 class="text-2xl font-semibold text-center mb-1">Atur Password Baru</h2>
            <p class="text-center text-gray-500 mb-6">Buat password baru untuk akun Anda</p>

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
            <form action="{{ route('alumni.reset-password') }}" method="POST">
                @csrf

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block font-medium mb-1">
                        Password Baru <span class="text-red-500">*</span>
                    </label>

                    <input 
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        class="w-full px-4 py-3 border rounded-lg 
                            @error('password') border-red-500 @enderror
                            focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    >

                    <p class="text-gray-500 text-sm mt-2">
                        Password harus minimal 8 karakter
                    </p>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-5">
                    <label for="password_confirmation" class="block font-medium mb-1">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>

                    <input 
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                        class="w-full px-4 py-3 border rounded-lg 
                            @error('password_confirmation') border-red-500 @enderror
                            focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    >

                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 rounded-lg transition"
                >
                    Reset Password
                </button>
            </form>

            <!-- Back Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600 mb-1">Ingat password?</p>
                <a href="{{ route('alumni.login.view') }}"
                class="text-indigo-500 font-medium hover:underline">
                    Masuk di sini
                </a>
            </div>

            <div class="my-6 border-t"></div>

            <!-- Info Box -->
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg text-sm">
                <strong>Catatan:</strong> Password Anda akan diubah setelah submit form ini.
            </div>

        </div>
    </div>

@endsection
