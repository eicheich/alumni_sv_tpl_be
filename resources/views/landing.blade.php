@extends('layouts.guest')

@section('title', 'Alumni TPL - Home')

@section('content')

    <section id="beranda"
        class="relative w-full min-h-screen flex items-center justify-center text-center text-white overflow-hidden">
        <img src="{{ asset('resources/images/hero.png') }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-950/95 via-purple-900/90 to-purple-950/95"></div>

        <div class="relative z-10 px-4 max-w-6xl mx-auto">
            <h1 data-aos="fade-up" data-aos-duration="1000"
                class="text-3xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                Selamat datang di Web Alumni TPL
            </h1>

            <p data-aos="fade-up" data-aos-duration="2000"
                class="max-w-3xl mx-auto text-lg md:text-xl lg:text-2xl mb-8 leading-relaxed font-light">
                Website Alumni TPL IPB dirancang sebagai pusat informasi untuk memperbarui data alumni, mendukung kebutuhan
                akademik, dan menampilkan prestasi alumni.
            </p>

            <div data-aos="fade-up" data-aos-duration="2500"
                class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('information.index') }}"
                    class="bg-purple-700 text-white font-bold px-8 py-4 rounded-2xl text-lg flex items-center gap-3">
                    <i data-feather="book-open" class="w-5 h-5"></i>
                    <span>Jelajahi Informasi</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Angka Alumni Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Lihat pencapaian dan perkembangan alumni kami dalam angka
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <!-- Stat 1 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-700 rounded-2xl mb-6">
                        <i data-feather="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($totalAlumni) }}</div>
                    <div class="text-lg font-semibold text-gray-800 mb-1">Alumni Terdaftar</div>
                    <div class="text-sm text-gray-600">Alumni yang terus berkembang</div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-800 rounded-2xl mb-6">
                        <i data-feather="award" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($totalOutstandingAlumni) }}</div>
                    <div class="text-lg font-semibold text-gray-800 mb-1">Alumni Berprestasi</div>
                    <div class="text-sm text-gray-600">Inspirasi untuk generasi mendatang</div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-900 rounded-2xl mb-6">
                        <i data-feather="file-text" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($totalInformation) }}</div>
                    <div class="text-lg font-semibold text-gray-800 mb-1">Informasi Terkini</div>
                    <div class="text-sm text-gray-600">Update terbaru untuk alumni</div>
                </div>
            </div>

            <!-- Additional Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-8 text-center border border-gray-100">
                    <div class="text-3xl font-black text-purple-800 mb-2">{{ number_format($totalPartnerCompanies) }}+</div>
                    <div class="text-lg font-semibold text-gray-800 mb-1">Perusahaan Partner</div>
                    <div class="text-sm text-gray-600">Menyediakan kesempatan karir</div>
                </div>

                <div class="bg-white rounded-3xl p-8 text-center border border-gray-100">
                    <div class="text-3xl font-black text-purple-900 mb-2">{{ number_format($totalWorkingAlumni) }}+</div>
                    <div class="text-lg font-semibold text-gray-800 mb-1">Alumni Berkarir</div>
                    <div class="text-sm text-gray-600">Telah bekerja di berbagai perusahaan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alumni Berprestasi -->

    <section id="prestasi" class="py-16 bg-white">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Alumni Berprestasi
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Prestasi dan pencapaian luar biasa dari alumni terbaik kami
            </p>
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex flex-wrap justify-center gap-8">

                <!-- Card-->
                @forelse($outstandingAlumni as $alumni)
                    <div class="bg-white rounded-2xl overflow-hidden w-full sm:w-64 border border-gray-100">
                        <div class="h-28 overflow-hidden">
                            <img src="{{ asset('resources/images/wave.svg') }}" class="h-40 w-full object-cover"
                                alt="">
                        </div>
                        <div class="-mt-20 flex justify-center">
                            @if ($alumni->alumni->user->photo_profile)
                                <img src="{{ asset('storage/' . $alumni->alumni->user->photo_profile) }}" alt="Alumni"
                                    class="rounded-full border-4 border-white w-24 h-24 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-400 flex items-center justify-center">
                                    <i data-feather="user" class="w-16 h-16 text-white/50"></i>
                                </div>
                            @endif
                        </div>
                        <div class="px-6 pb-6 pt-2 text-center">
                            <p class="text-xs text-purple-700 font-medium">{{ $alumni->award_title }}</p>
                            <h3 class="text-lg font-semibold mt-1">{{ $alumni->alumni->user->name ?? 'Nama Alumni' }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $alumni->alumni->major->name ?? 'Program Studi' }}</p>
                            <p class="text-sm font-medium text-gray-800 mb-4"><i
                                    class="fa-solid me-1 fa-briefcase text-purple-700"></i>
                                @if ($alumni->alumni->educationalBackgrounds->isNotEmpty())
                                    Tahun Lulus:
                                    {{ $alumni->alumni->educationalBackgrounds->first()->graduation_year ?? '-' }}
                                @else
                                    -
                                @endif
                            </p>
                            <a href="{{ route('outstanding-alumni.show', encrypt($alumni->id)) }}"
                                class="inline-block bg-purple-700 text-white px-4 py-2 rounded-md text-sm">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center">
                        <p class="text-muted">Belum ada alumni berprestasi</p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- CTA Button --}}
        <div class="flex justify-center mt-12">
            <a href="{{ route('outstanding-alumni.index') }}"
                class="bg-purple-700 text-white font-semibold px-8 py-3 rounded-xl text-base hover:bg-purple-800 flex items-center gap-3">
                <span>Lihat Semua Alumni Berprestasi</span>
                <i data-feather="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </section>


    <!-- Informasi Terkini -->
    <section id="informasi" class="bg-gray-50 py-16 pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Informasi Terkini
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Berita, pengumuman, dan informasi penting untuk alumni
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse ($latestInformation as $information)
                    <article class="bg-white rounded-2xl overflow-hidden flex flex-col h-full border border-gray-100">

                        {{-- Gambar cover --}}
                        <div class="aspect-[16/9] overflow-hidden relative">
                            @if ($information->cover_image)
                                <img src="{{ asset('storage/' . $information->cover_image) }}"
                                    class="w-full h-full object-cover" alt="{{ $information->title }}">
                            @elseif ($information->imageContents->first())
                                <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                                    class="w-full h-full object-cover" alt="{{ $information->title }}">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i data-feather="file-text" class="w-16 h-16 text-gray-400"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-purple-700 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                    {{ $information->category->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-xl mb-3 line-clamp-2 leading-tight text-gray-900">
                                {{ Str::limit($information->title, 80) }}
                            </h3>

                            <div class="text-gray-600 flex-grow mb-4 leading-relaxed text-sm">
                                {!! Str::words(make_links_clickable(strip_tags($information->content)), 20, '...') !!}
                            </div>

                            <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>{{ $information->created_at->diffForHumans() }}</span>
                                </div>

                                <a href="{{ route('information.show', encrypt($information->id)) }}"
                                    class="text-purple-700 text-sm font-semibold hover:text-purple-800 hover:underline flex items-center">
                                    Baca Selengkapnya
                                    <i data-feather="arrow-right" class="w-4 h-4 ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="bg-white rounded-2xl p-12 max-w-lg mx-auto border border-gray-100">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-feather="inbox" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-gray-900">Belum Ada Informasi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Informasi terbaru akan segera dipublikasikan di halaman ini
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Button --}}
            <div class="flex justify-center">
                <a href="{{ route('information.index') }}"
                    class="bg-purple-700 text-white font-semibold px-8 py-3 rounded-xl text-base hover:bg-purple-800 flex items-center gap-3">
                    <span>Lihat Semua Informasi</span>
                    <i data-feather="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-purple-700">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Siap Bergabung dengan Alumni TPL SV IPB?
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white/10 rounded-3xl p-8">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-feather="user-plus" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Daftar Sekarang</h3>
                    <p class="text-white/80 mb-6">Mari menjadi bagian dari jaringan alumni TPL IPB.</p>
                    <a href="{{ route('alumni.validate-data.view') }}"
                        class="inline-block bg-white text-purple-700 font-bold px-6 py-3 rounded-xl hover:bg-gray-100">
                        Daftar Alumni
                    </a>
                </div>

                <div class="bg-white/10 rounded-3xl p-8">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-feather="search" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Jelajahi Informasi</h3>
                    <p class="text-white/80 mb-6">Temukan berita terkini, lowongan pekerjaan, dan informasi penting lainnya
                    </p>
                    <a href="{{ route('information.index') }}"
                        class="inline-block bg-white text-purple-700 font-bold px-6 py-3 rounded-xl hover:bg-gray-100">
                        Lihat Informasi
                    </a>
                </div>

                <div class="bg-white/10 rounded-3xl p-8">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-feather="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Lihat Profil Alumni</h3>
                    <p class="text-white/80 mb-6">Temukan dan pelajari tentang prestasi alumni berbakat kami</p>
                    <a href="{{ route('outstanding-alumni.index') }}"
                        class="inline-block bg-white text-purple-700 font-bold px-6 py-3 rounded-xl hover:bg-gray-100">
                        Lihat Profil Alumni
                    </a>
                </div>
            </div>

            <div class="bg-white/10 rounded-3xl p-8 max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold text-white mb-4">Butuh Bantuan?</h3>
                <p class="text-white/80 mb-6">Tim kami siap membantu Anda dengan pertanyaan seputar platform alumni</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('faq.index') }}"
                        class="inline-flex items-center justify-center bg-white/20 text-white font-semibold px-6 py-3 rounded-xl hover:bg-white/30">
                        <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                        FAQ
                    </a>
                    <a href="{{ route('about.index') }}"
                        class="inline-flex items-center justify-center bg-white/20 text-white font-semibold px-6 py-3 rounded-xl hover:bg-white/30">
                        <i data-feather="info" class="w-5 h-5 mr-2"></i>
                        Tentang Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="py-16"></div>

    <!-- Footer -->
    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
