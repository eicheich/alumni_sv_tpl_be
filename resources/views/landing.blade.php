@extends('layouts.guest')

@section('title', 'Alumni TPL - Home')

@section('content')
    <!-- Header -->
    @include('components.landing-header')

    <!-- Section 1: Hero dengan Background Gradient -->
    <section id="beranda" class="py-5 text-white text-center"
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
    </section>

    <!-- Section 2: Alumni Berprestasi -->
    <section id="alumni-berprestasi" class="py-5">
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
    </section>

    <!-- Section 3: Informasi Umum Terbaru -->
    <section id="informasi" class="py-5 bg-light">
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
                    <a href="#" class="btn btn-primary btn-lg">
                        <i data-feather="arrow-right" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
