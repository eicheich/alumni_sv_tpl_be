@extends('layouts.guest')

@section('title', 'Login Alumni')

@section('content')



    
    <div class="flex items-start justify-center bg-gray-100 ">
        <div class="overflow-hidden w-full flex flex-col lg:flex-row h-screen">

        <!-- Bagian Kiri: Form -->
            <div class="w-full p-8 flex flex-col mt-8">
                <h2 class="text-base font-semibold text-gray-800 text-center">Masuk</h2>
                <p class="text-sm text-gray-500 text-center mt-1 mb-6 mx-20">
                Masuk dengan menggunakan email IPB
                </p>

                {{-- @if ($errors->any())
                    <div class="bg-red-500" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <form class="space-y-4 mx-20" action="{{ route('alumni.login') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" placeholder="contoh@apps.ipb.ac.id"
                        class="w-full px-3 py-2 rounded-md border border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('email') border border-red-500 @enderror" id="email" name="email" placeholder="nama@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata sandi</label>
                        <input type="password"
                        class="w-full px-3 py-2 rounded-md border border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('password') border border-red-500 @enderror"
                            id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                     

                    <button type="submit"
                        class="w-full bg-purple-500 text-white py-2 rounded-md text-sm font-medium hover:opacity-90 transition">
                        Masuk
                    </button>

                </form>
                
                <div class="text-center mt-3 relative z-99">
                    <a href="{{ route('alumni.forgot-password-view') }}"> 
                        Lupa password?
                    </a>
                   
                </div>

                <div class="text-center mt-4 relative z-99">
                    <p class="mb-2 text-gray-700">Belum punya akun?</p>
                    <a href="{{ route('alumni.validate-data.view') }}" 
                    class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-150 block **w-full**"> 
                        Daftar di sini
                    </a>
                </div>
            </div>

            <!-- Bagian Kanan: Gambar -->
            <div class="w-full hidden lg:relative">
                <img src="{{ asset('storage/asset/cover.png')}}" alt="Kampus IPB"
                    class="object-cover w-full h-40 lg:h-full">
                <div class="absolute inset-0 bg-gradient-to-t from-purple-700/40 to-purple-400/30"></div>
            </div>
        </div>
    </div>



  @include('components.landing-footer')
@endsection
