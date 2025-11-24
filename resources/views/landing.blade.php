@extends('layouts.guest')

@section('title', 'Alumni TPL - Home')

@section('content')


    <section id="beranda" class="relative w-full h-[70vh] flex items-center justify-center text-center text-white">
        <img src="{{ asset('resources/images/hero.png') }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover">
        <div class="relative z-10 px-4">
            <h1 data-aos="fade-up" data-aos-duration="1000" class="text-2xl md:text-4xl font-bold mb-3">Selamat datang di Web
                Alumni TPL</h1>
            <p data-aos="fade-up" data-aos-duration="2000" class="max-w-2xl mx-auto text-sm md:text-base">
                Website Alumni TPL IPB dirancang sebagai pusat informasi untuk memperbarui data alumni,
                mendukung kebutuhan akademik, dan menampilkan prestasi alumni.
            </p>
        </div>
    </section>

    <!-- Alumni Berprestasi -->

    <section id="prestasi" class="py-16 bg-white">
        <h2 class="text-xl mb-4 text-center mt-10 md:text-2xl font-semibold">
            Alumni Berprestasi</h2>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex flex-wrap justify-center gap-8">

                <!-- Card-->
                @forelse($outstandingAlumni as $alumni)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-full sm:w-64">
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
                            <p class="text-xs text-purple-600 font-medium">{{ $alumni->award_title }}</p>
                            <h3 class="text-lg font-semibold mt-1">{{ $alumni->alumni->user->name ?? 'Nama Alumni' }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $alumni->alumni->major->name ?? 'Program Studi' }}</p>
                            <p class="text-sm font-medium text-gray-800 mb-4"><i
                                    class="fa-solid me-1 fa-briefcase text-purple-600"></i>
                                @if ($alumni->alumni->educationalBackgrounds->isNotEmpty())
                                    Tahun Lulus:
                                    {{ $alumni->alumni->educationalBackgrounds->first()->graduation_year ?? '-' }}
                                @else
                                    -
                                @endif
                            </p>
                            <a href="{{ route('outstanding-alumni.show', $alumni->id) }}"
                                class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">
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
    </section>


    <!-- Informasi Terkini -->
    <section id="informasi" class="bg-purple-700 text-white py-16 pb-28">
        <h2 class="text-center text-xl md:text-2xl font-semibold mb-10">
            Informasi Terkini</h2>

        <div class="max-w-6xl mx-auto px-6 flex flex-wrap justify-center gap-8">
            @forelse ($latestInformation as $information)
                <div class="bg-white text-gray-800 rounded-xl overflow-hidden shadow-lg flex flex-col w-full sm:w-80">

                    {{-- Gambar cover --}}
                    @if ($information->cover_image)
                        <img src="{{ asset('storage/' . $information->cover_image) }}" class="w-full h-48 object-cover"
                            alt="{{ $information->title }}">
                    @elseif ($information->imageContents->first())
                        <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                            class="w-full h-48 object-cover" alt="{{ $information->title }}">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <i data-feather="image" class="w-12 h-12 text-gray-500"></i>
                        </div>
                    @endif

                    <div class="p-4 flex flex-col flex-grow">
                        <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-full self-start mb-2">
                            {{ $information->category->name ?? 'Umum' }}
                        </span>

                        <h3 class="font-semibold text-sm mb-2">
                            {{ Str::limit($information->title, 60) }}
                        </h3>

                        <p class="text-xs text-gray-600 flex-grow">
                            {{ Str::limit(strip_tags($information->content), 100) }}
                        </p>

                        <div class="flex justify-between items-center mt-3">
                            <span class="text-xs text-gray-500">
                                {{ $information->created_at->diffForHumans() }}
                            </span>

                            <a href="{{ route('information.show', $information->id) }}"
                                class="text-purple-600 text-xs font-medium hover:underline relative z-99">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="w-full text-center py-12 text-white">
                    <i data-feather="inbox" class="w-12 h-12 mx-auto mb-3"></i>
                    Belum ada informasi
                </div>
            @endforelse
        </div>

        {{-- Button --}}
        <div class="flex justify-center mt-8">
            <a href="{{ route('information.index') }}"
                class="bg-white text-purple-700 font-medium px-5 py-2 rounded-md text-sm hover:bg-gray-100 flex items-center relatice z-99 gap-2">
                <i data-feather="arrow-right" class="w-4 h-4"></i>
                Lihat Selengkapnya
            </a>
        </div>
    </section>

    <div class="py-16"></div>

    <!-- Footer -->









    <!-- Section 1: Hero dengan Background Gradient -->
    {{-- <section id="beranda" class="py-5 text-white text-center"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 500px; display: flex; align-items: center; justify-content: center;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">Selamat Datang di Web Alumni TPL</h1>
                    <p class="lead mb-4">Website Alumni TPL IPB dirancang sebagai pusat informasi untuk memperbarui data
                        alumni, mendukung kebutuhan akademik, dan menampilkan prestasi alumni.</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Section 2: Alumni Berprestasi -->
    {{-- <section id="alumni-berprestasi" class="py-5">
        <div class="container-fluid">
            <h2 class="text-center mb-5 fw-bold">Alumni Berprestasi</h2>
            <div class="row justify-content-center">
                @forelse($outstandingAlumni as $alumni)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if ($alumni->alumni->user->photo_profile)
                                <img src="{{ asset('storage/' . $alumni->alumni->user->photo_profile) }}"
                                    class="card-img-top" alt="{{ $alumni->alumni->user->name }}"
                                    style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                    style="height: 250px;">
                                    <i data-feather="user"
                                        style="width: 64px; height: 64px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            @endif
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">{{ $alumni->award_title }}</h6>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $alumni->alumni->user->name ?? 'Nama Alumni' }}</h5>
                                <p class="card-text text-muted small">
                                    <i data-feather="briefcase" style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                    {{ $alumni->alumni->major->name ?? 'Program Studi' }}
                                </p>
                                <p class="card-text small text-muted">
                                    @if ($alumni->alumni->educationalBackgrounds->isNotEmpty())
                                        Tahun Lulus:
                                        {{ $alumni->alumni->educationalBackgrounds->first()->graduation_year ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <a href="{{ route('outstanding-alumni.show', $alumni->id) }}"
                                    class="btn btn-primary btn-sm w-100">
                                    <i data-feather="eye" style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                    Lihat Profil
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada alumni berprestasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section> --}}

    <!-- Section 3: Informasi Umum Terbaru -->
    {{-- <section id="informasi" class="py-5 bg-light">
        <div class="container-fluid">
            <h2 class="text-center mb-5 fw-bold">Informasi Umum Terbaru</h2>
            <div class="row justify-content-center">
                @forelse($latestInformation as $info)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if ($info->cover_image)
                                <img src="{{ asset('storage/' . $info->cover_image) }}" class="card-img-top"
                                    alt="{{ $info->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i data-feather="image"
                                        style="width: 48px; height: 48px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <span class="badge bg-info mb-2">{{ $info->category->name ?? 'Umum' }}</span>
                                <h5 class="card-title">{{ $info->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit(strip_tags($info->content), 100) }}</p>
                                <small class="text-muted">{{ $info->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada informasi</p>
                    </div>
                @endforelse
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('information.index') }}" class="btn btn-primary btn-lg">
                        <i data-feather="arrow-right" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Footer -->
    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
