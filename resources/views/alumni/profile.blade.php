@extends('layouts.guest')

@section('content')
    @include('components.profile-header')

    <div class="container mt-5 mb-5">
        <h1 class="h3 mb-4">Profile Saya</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if (auth('alumni')->user()->photo_profile)
                            <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                                alt="{{ auth('alumni')->user()->name }}" class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 150px; height: 150px;">
                                <i data-feather="user" style="width: 64px; height: 64px; color: white;"></i>
                            </div>
                        @endif
                        <h5 class="card-title">{{ auth('alumni')->user()->name }}</h5>
                        <p class="card-text text-muted small">Alumni TPL</p>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informasi Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Nama</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Email</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Nomor Telepon</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Terdaftar Sejak</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (auth('alumni')->user()->alumni)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Data Alumni</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">NIM</p>
                                    <p class="fw-bold">{{ auth('alumni')->user()->alumni->nim }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">Program Studi</p>
                                    <p class="fw-bold">{{ auth('alumni')->user()->alumni->major->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">Tanggal Lahir</p>
                                    <p class="fw-bold">
                                        @if (auth('alumni')->user()->alumni->birthdate)
                                            {{ \Carbon\Carbon::parse(auth('alumni')->user()->alumni->birthdate)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Latar Belakang Pendidikan</h5>
                            <a href="{{ route('alumni.educational-backgrounds') }}" class="btn btn-sm btn-primary">
                                <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if (auth('alumni')->user()->alumni->educationalBackgrounds->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach (auth('alumni')->user()->alumni->educationalBackgrounds->take(2) as $background)
                                        <div class="list-group-item px-0 py-2 border-0">
                                            <p class="fw-bold mb-1">{{ $background->institution_name }}</p>
                                            <small class="text-muted">{{ $background->degree }} •
                                                {{ $background->entry_year }} - {{ $background->graduation_year }}</small>
                                        </div>
                                    @endforeach
                                </div>
                                @if (auth('alumni')->user()->alumni->educationalBackgrounds->count() > 2)
                                    <p class="text-muted small mt-2">
                                        +{{ auth('alumni')->user()->alumni->educationalBackgrounds->count() - 2 }} lainnya
                                    </p>
                                @endif
                            @else
                                <p class="text-muted mb-0">Belum ada data latar belakang pendidikan</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Karir</h5>
                            <a href="{{ route('alumni.careers') }}" class="btn btn-sm btn-primary">
                                <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if (auth('alumni')->user()->alumni->career)
                                <p class="fw-bold mb-1">{{ auth('alumni')->user()->alumni->career->position }}</p>
                                <p class="text-muted mb-2">{{ auth('alumni')->user()->alumni->career->company_name }}</p>
                                <small class="text-secondary">
                                    {{ \Carbon\Carbon::parse(auth('alumni')->user()->alumni->career->start_date)->format('M Y') }}
                                    -
                                    @if (auth('alumni')->user()->alumni->career->end_date)
                                        {{ \Carbon\Carbon::parse(auth('alumni')->user()->alumni->career->end_date)->format('M Y') }}
                                    @else
                                        <span class="badge bg-success">Sekarang</span>
                                    @endif
                                </small>
                            @else
                                <p class="text-muted mb-0">Belum ada data karir</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Keamanan</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Kelola password dan keamanan akun Anda</p>
                        <a href="{{ route('alumni.change-password-view') }}" class="btn btn-sm btn-primary">
                            <i data-feather="edit" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Ubah Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

<script>
    feather.replace();
</script>
