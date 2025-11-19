@extends('layouts.main')

@section('title', 'Profile Alumni')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Profile Saya</h1>
        </div>

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
@endsection
