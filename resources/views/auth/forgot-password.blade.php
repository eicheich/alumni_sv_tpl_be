@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            
            <!-- Heading -->
            <h2 class="text-2xl font-semibold text-center mb-1">Lupa Password?</h2>
            <p class="text-center text-gray-500 mb-6">Masukkan email Anda untuk mereset password</p>

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
            <form action="{{ route('alumni.forgot-password') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block font-medium mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input 
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama@example.com"
                        class="
                            w-full px-4 py-3 border rounded-lg text-gray-700 
                            focus:outline-none focus:ring-2 focus:ring-indigo-400
                            @error('email') border-red-500 @enderror
                        "
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 rounded-lg transition"
                >
                    Kirim OTP
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600 mb-1">Ingat password?</p>
                <a href="{{ route('alumni.login.view') }}" class="text-indigo-500 font-medium hover:underline">
                    Masuk di sini
                </a>
            </div>

            <div class="my-6 border-t"></div>

            <!-- Info Box -->
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg text-sm">
                <strong>Catatan:</strong> Kami akan mengirimkan kode OTP ke email Anda untuk memverifikasi identitas.
            </div>

        </div>
    </div>

@endsection
