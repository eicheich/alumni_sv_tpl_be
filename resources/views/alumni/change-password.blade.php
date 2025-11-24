@extends('layouts.guest')

@section('content')
    <div class="flex justify-center py-10 px-4">
        <div class="w-full max-w-lg">

            <!-- Card -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                <!-- Header -->
                <div class="bg-purple-600 px-6 py-4">
                    <h5 class="text-white font-semibold text-lg">Ubah Password</h5>
                </div>

                <!-- Body -->
                <div class="p-6">

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 relative">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button 
                                type="button" 
                                onclick="this.parentElement.remove()" 
                                class="absolute top-2 right-2 text-red-700 text-xl leading-none"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('alumni.change-password') }}" method="POST">
                        @csrf

                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="current_password" class="block text-gray-700 font-medium mb-1">
                                Password Saat Ini
                            </label>
                            <input 
                                type="password"
                                id="current_password"
                                name="current_password"
                                required
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg border focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="new_password" class="block text-gray-700 font-medium mb-1">
                                Password Baru
                            </label>
                            <input 
                                type="password"
                                id="new_password"
                                name="new_password"
                                required minlength="8"
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg border focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none @error('new_password') border-red-500 @enderror">

                            <p class="text-gray-500 text-xs mt-1">Minimal 8 karakter</p>

                            @error('new_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="block text-gray-700 font-medium mb-1">
                                Konfirmasi Password Baru
                            </label>
                            <input 
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                required
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg border focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none @error('new_password_confirmation') border-red-500 @enderror">

                            @error('new_password_confirmation')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 mt-6">
                            <button type="submit"
                                class="px-5 py-2 bg-purple-600 text-white rounded-lg font-medium 
                                    hover:bg-purple-700 transition">
                                Ubah Password
                            </button>

                            <a href="{{ route('alumni.profile') }}"
                                class="px-5 py-2 bg-gray-200 rounded-lg font-medium text-gray-800 
                                    hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

@endsection
