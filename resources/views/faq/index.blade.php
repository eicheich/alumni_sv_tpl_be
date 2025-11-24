@extends('layouts.guest')

@section('title', 'Alumni TPL - Home')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-32"
        style="background-image: url('{{ asset('resources/images/hero.png') }}');">
        <div class="absolute inset-0 bg-purple-900 bg-opacity-70"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">FAQ</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto text-white">
                Pertanyaan yang sering ditanyakan tentang Website Alumni Teknologi Rekayasa Perangkat Lunak SV IPB
            </p>
        </div>
    </section>

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Bagaimana cara mendaftar sebagai alumni?</h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Untuk mendaftar sebagai alumni, kunjungi halaman registrasi dan ikuti langkah-langkah
                                berikut:</p>
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Masukkan data diri Anda (nama, NIM, tahun lulus)</li>
                                <li>Verifikasi email dengan OTP yang dikirim</li>
                                <li>Lengkapi profil dengan informasi pendidikan dan karir</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Bagaimana cara mengupdate informasi profil?</h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Setelah login, Anda dapat mengupdate informasi profil melalui menu "Profile". Di sana Anda
                                dapat:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Mengubah foto profil</li>
                                <li>Menambah/mengedit riwayat pendidikan</li>
                                <li>Menambah/mengedit informasi karir</li>
                                <li>Mengubah password</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Bagaimana cara melihat informasi umum?</h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Informasi umum dapat dilihat di halaman "Informasi Umum" tanpa perlu login. Informasi
                                tersebut mencakup:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Berita dan pengumuman terbaru</li>
                                <li>Acara dan kegiatan alumni</li>
                                <li>Informasi karir dan lowongan pekerjaan</li>
                                <li>Profil alumni berprestasi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Apa yang harus dilakukan jika lupa password?
                            </h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Jika Anda lupa password, ikuti langkah-langkah reset password:</p>
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Klik "Lupa Password" di halaman login</li>
                                <li>Masukkan email yang terdaftar</li>
                                <li>Verifikasi dengan OTP yang dikirim ke email</li>
                                <li>Buat password baru</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Bagaimana cara berpartisipasi dalam acara
                                alumni?</h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Untuk berpartisipasi dalam acara alumni:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Pantau pengumuman acara di halaman "Informasi Umum"</li>
                                <li>Daftar melalui link pendaftaran yang disediakan</li>
                                <li>Ikuti instruksi konfirmasi yang dikirim via email</li>
                                <li>Hadiri acara sesuai jadwal yang ditentukan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 6 -->


                <!-- FAQ Item 7 -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq(this)">
                            <h3 class="text-lg font-semibold text-gray-900">Bagaimana cara melihat profil alumni lain?</h3>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4 text-gray-700">
                            <p>Untuk saat ini, profil alumni lain dapat dilihat melalui:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Halaman "Alumni Berprestasi" untuk profil alumni yang telah diverifikasi</li>
                                <li>Informasi kontak yang dibagikan dalam acara alumni</li>
                                <li>Grup komunikasi alumni (WhatsApp, LinkedIn, dll.)</li>
                            </ul>
                            <p class="mt-2">Fitur networking antar alumni akan dikembangkan di masa depan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4">Masih ada pertanyaan?</p>
                <a href="{{ route('about.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                    Lihat Halaman Tentang Kami
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(button) {
            const content = button.parentElement.querySelector('.faq-content');
            const icon = button.querySelector('svg');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>

    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
@endsection
