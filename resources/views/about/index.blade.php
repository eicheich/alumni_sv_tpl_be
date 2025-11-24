@extends('layouts.guest')

@section('title', 'Alumni TPL - Home')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-32"
        style="background-image: url('{{ asset('resources/images/hero.png') }}');">
        <div class="absolute inset-0 bg-purple-900 bg-opacity-70"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">Tentang Kami</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto text-white">
                Website Alumni Teknologi Rekayasa Perangkat Lunak SV IPB
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Visi -->
            <div class="bg-white rounded-lg border border-gray-200 p-8 mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Visi</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Menjadi platform informasi dan dokumentasi alumni Teknologi Rekayasa Perangkat Lunak SV IPB yang
                    profesional dan mudah diakses, serta menampilkan profil dan pencapaian alumni sebagai inspirasi bagi
                    generasi selanjutnya.
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-white rounded-lg border border-gray-200 p-8 mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Misi</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <span class="text-purple-600 font-bold mr-3">•</span>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Menyediakan platform digital yang memudahkan alumni dalam mengelola profil, berbagi
                            informasi karir, dan mengakses informasi terkini.
                        </p>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 font-bold mr-3">•</span>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Menampilkan profil dan pencapaian alumni yang berprestasi sebagai inspirasi bagi alumni
                            lainnya.
                        </p>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 font-bold mr-3">•</span>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Menyajikan informasi dan berita terkini yang relevan bagi alumni Teknologi Rekayasa
                            Perangkat Lunak.
                        </p>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 font-bold mr-3">•</span>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Memfasilitasi pendataan dan dokumentasi riwayat pendidikan serta karir alumni secara
                            digital.
                        </p>
                    </li>
                </ul>
            </div>

            <!-- Fitur Website -->
            <div class="bg-white rounded-lg border border-gray-200 p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Fitur Website Alumni</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Profil Alumni</h3>
                        <p class="text-gray-600">
                            Kelola profil pribadi, riwayat pendidikan, dan pengalaman karir Anda.
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Informasi Terkini</h3>
                        <p class="text-gray-600">
                            Akses berita, pengumuman, dan informasi penting seputar dunia alumni.
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Alumni Berprestasi</h3>
                        <p class="text-gray-600">
                            Inspirasi dari kisah sukses alumni yang berprestasi di berbagai bidang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-landing-footer />

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    </body>

    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
