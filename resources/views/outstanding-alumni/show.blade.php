@extends('layouts.guest')

@section('content')
    @include('components.profile-header')

    <div class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Alumni Berprestasi</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            @if ($outstandingAlumni->alumni->user->photo_profile)
                                <img src="{{ asset('storage/' . $outstandingAlumni->alumni->user->photo_profile) }}"
                                    alt="{{ $outstandingAlumni->alumni->user->name }}" class="rounded-circle mb-3"
                                    style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #0d6efd;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 180px; height: 180px; border: 4px solid #0d6efd;">
                                    <i data-feather="user" style="width: 80px; height: 80px; color: white;"></i>
                                </div>
                            @endif
                            <h4 class="fw-bold mb-2">{{ $outstandingAlumni->alumni->user->name }}</h4>
                            <p class="text-muted mb-3">{{ $outstandingAlumni->alumni->major->name ?? 'Program Studi' }}</p>
                            <div class="alert alert-primary mb-3" role="alert">
                                <i data-feather="award" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                                <strong>{{ $outstandingAlumni->award_title }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Informasi Kontak</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">
                                    <i data-feather="mail" style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                    Email
                                </small>
                                <p class="mb-0">{{ $outstandingAlumni->alumni->user->email ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">
                                    <i data-feather="phone" style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                    Telepon
                                </small>
                                <p class="mb-0">{{ $outstandingAlumni->alumni->user->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">
                                    <i data-feather="hash" style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                    NIM
                                </small>
                                <p class="mb-0">{{ $outstandingAlumni->alumni->nim ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="col-lg-8">
                    <!-- Educational Background -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i data-feather="book" style="width: 20px; height: 20px; margin-right: 8px;"></i>
                                Latar Belakang Pendidikan
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($outstandingAlumni->alumni->educationalBackgrounds->count() > 0)
                                @foreach ($outstandingAlumni->alumni->educationalBackgrounds as $education)
                                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <h6 class="fw-bold mb-1">{{ $education->degree }}</h6>
                                        <p class="mb-1">{{ $education->institution_name }}</p>
                                        @if ($education->major)
                                            <p class="text-muted small mb-1">{{ $education->major }}</p>
                                        @endif
                                        @if ($education->faculty)
                                            <p class="text-muted small mb-1">{{ $education->faculty }}</p>
                                        @endif
                                        <p class="text-muted small mb-0">
                                            <i data-feather="calendar"
                                                style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                            {{ $education->entry_year }} - {{ $education->graduation_year }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Belum ada data pendidikan</p>
                            @endif
                        </div>
                    </div>

                    <!-- Career History -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i data-feather="briefcase" style="width: 20px; height: 20px; margin-right: 8px;"></i>
                                Riwayat Karir
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($outstandingAlumni->alumni->careers->count() > 0)
                                @foreach ($outstandingAlumni->alumni->careers as $career)
                                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $career->position }}</h6>
                                                <p class="mb-1">{{ $career->company_name }}</p>
                                                <p class="text-muted small mb-0">
                                                    <i data-feather="calendar"
                                                        style="width: 14px; height: 14px; margin-right: 5px;"></i>
                                                    {{ \Carbon\Carbon::parse($career->start_date)->format('M Y') }} -
                                                    @if ($career->end_date)
                                                        {{ \Carbon\Carbon::parse($career->end_date)->format('M Y') }}
                                                    @else
                                                        <span class="badge bg-success">Sekarang</span>
                                                    @endif
                                                </p>
                                            </div>
                                            @if (!$career->end_date)
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Belum ada data karir</p>
                            @endif
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-3">
                        <a href="{{ route('index') }}#alumni-berprestasi" class="btn btn-outline-secondary">
                            <i data-feather="arrow-left" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
