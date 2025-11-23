@extends('layouts.guest')

@section('title', 'Register Alumni')

@section('content')
    {{-- <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 500px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-1">Daftar sebagai Alumni</h2>
                <p class="text-center text-muted mb-4">Masukkan Email dan NIM Anda untuk memulai proses pendaftaran</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.validate-data') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="nama@example.com" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM) <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('nim') is-invalid @enderror"
                            id="nim" name="nim" placeholder="Contoh: 12345678" value="{{ old('nim') }}"
                            required>
                        @error('nim')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-lg w-100"
                        style="background-color: #667eea; border-color: #667eea; color: white;">
                        Validasi Data
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-2">Sudah punya akun?</p>
                    <a href="{{ route('alumni.login.view') }}" class="text-decoration-none" style="color: #667eea;">
                        Masuk di sini
                    </a>
                </div>

                <hr class="my-4">

                <div class="alert alert-info" role="alert">
                    <small>
                        <i class="feather icon-info"></i>
                        <strong>Perhatian:</strong> Pastikan email dan NIM sudah terdaftar di sistem Alumni TPL untuk
                        melanjutkan proses pendaftaran.
                    </small>
                </div>
            </div>
        </div>
    </div> --}}






    <div class="flex items-start justify-center bg-gray-100 ">
        <div class="overflow-hidden w-full flex flex-col lg:flex-row h-screen">

        <!-- Bagian Kiri: Form -->
        <div class="w-full p-8 flex flex-col mt-8">
            <h2 class="text-base font-semibold text-gray-800 text-center">Daftar Akun Alumni</h2>
            <p class="text-sm text-gray-500 text-center mt-1 mb-6 mx-20">
            Mohon masukkan Email dan NIM IPB, data akan divalidasi sesuai dengan database prodi
            </p>

            <form class="space-y-4 mx-20" action="{{ route('alumni.validate-data') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" class="w-full px-3 py-2 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('email') border border-red-500 @enderror"
                        id="email" name="email" placeholder="nama@example.com" value="{{ old('email') }}"
                        required>
                    @error('email')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                    <input type="text" class="w-full px-3 py-2 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm @error('nim') border border-red-500 @enderror"
                        id="nim" name="nim" placeholder="Contoh: j04xxxxx" value="{{ old('nim') }}"
                        required>
                    @error('nim')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-purple-500 text-white py-2 rounded-md text-sm font-medium hover:opacity-90 transition relative z-99">
                    Daftar
                </button>
            </form>
            <div class="text-center mt-4 relative z-98">
                <p class="mb-2">Sudah punya akun?</p>
                <a href="{{ route('alumni.login.view') }}" class="text-decoration-none" style="color: #667eea;">
                    Masuk di sini
                </a>
            </div>
        </div>

        <!-- Bagian Kanan: Gambar -->
        <div class="w-full relative">
            <img src="{{ asset('storage/asset/cover.png')}}" alt="Kampus IPB"
                class="object-cover w-full h-48 lg:h-full">
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
