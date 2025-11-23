@extends('layouts.guest')

@section('title', 'Login Alumni')

@section('content')

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-12 py-4 bg-white shadow-sm">
        <div class="font-semibold text-lg flex"><img src="asset/logo.png" class="h-8 mr-2" alt="">Web Alumni TPL</div>
        <ul class="hidden md:flex space-x-6 text-sm font-medium">
            <li><a href="#beranda" class="text-purple-600">Beranda</a></li>
            <li><a href="#tentang" class="hover:text-purple-600">Tentang</a></li>
            <li><a href="#informasi" class="hover:text-purple-600">Informasi Umum</a></li>
        </ul>
        <div class="space-x-2">
            <button class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">Masuk</button>
            <button class="bg-purple-400 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-500">Daftar</button>
        </div>
    </nav>


    
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
            <div class="w-full relative">
                <img src="{{ asset('storage/asset/cover.png')}}" alt="Kampus IPB"
                    class="object-cover w-full h}}-48 lg:h-full">
                <div class="absolute inset-0 bg-gradient-to-t from-purple-700/40 to-purple-400/30"></div>
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="-mt-28 md:-mt-60 flex justify-center z-50">
            <img src="{{asset('storage/asset/foot.svg')}}" class="top-0 left-0 w-full object-cover" alt="">
        </div>
    </div>


  <!-- Footer -->
  <footer class="bg-purple-900 text-white pb-10">
    <div class="max-w-6xl mx-12 grid md:grid-cols-3 gap-8">
      <!-- Kiri -->
      <div>
        <h3 class="font-semibold text-lg mb-4">Web Alumni TPL</h3>
        <div class="flex flex-col space-y-2">
          <a href="#" class="bg-purple-700 text-white px-4 py-2 rounded-md w-fit hover:bg-purple-600"><i class="fa-brands fa-twitter me-1"></i>Twitter</a>
          <a href="#" class="bg-purple-700 text-white px-4 py-2 rounded-md w-fit hover:bg-purple-600"><i class="fa-brands fa-instagram me-1"></i>Instagram</a>
        </div>
      </div>

      <!-- Tengah -->
      <div>
        <h3 class="font-semibold mb-4">Tautan</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#beranda" class="hover:underline">Beranda</a></li>
          <li><a href="#tentang" class="hover:underline">Tentang</a></li>
          <li><a href="#informasi" class="hover:underline">Informasi Umum</a></li>
        </ul>
      </div>

      <!-- Kanan -->
      <div>
        <h3 class="font-semibold mb-4">Alamat & Kontak</h3>
        <p class="text-sm">
          KAMPUS BOGOR - Jl. Kumbang No.14, Kelurahan Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128
        </p>
        <p class="text-sm mt-2">Telepon: (0251) 8348007</p>
        <p class="text-sm mt-1">Email: sv@apps.ipb.ac.id</p>
      </div>
    </div>

    <div class="text-center mt-8 text-xs text-gray-300">
      Copyright © 2025 Web Alumni TPL
    </div>
  </footer>
@endsection
