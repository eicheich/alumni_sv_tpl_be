@extends('layouts.guest')

@section('title', 'Registrasi Berhasil')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 500px;">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="feather icon-check-circle" style="font-size: 64px; color: #28a745;"></i>
                </div>

                <h2 class="mb-3">Registrasi Berhasil!</h2>
                <p class="text-muted mb-4">
                    Selamat! Akun alumni Anda telah berhasil dibuat dan diaktifkan. Anda sekarang dapat masuk menggunakan
                    email dan password yang telah Anda buat.
                </p>

                <div class="alert alert-success" role="alert">
                    <small>
                        <strong>✓ Profil Anda telah diperbarui</strong><br>
                        Nomor telepon dan password telah tersimpan dengan aman.
                    </small>
                </div>

                <a href="{{ route('alumni.login.view') }}" class="btn btn-lg w-100"
                    style="background-color: #667eea; border-color: #667eea; color: white;">
                    Masuk ke Akun Saya
                </a>

                <div class="mt-4 text-center">
                    <small class="text-muted">
                        Kembali ke <a href="{{ route('index') }}" class="text-decoration-none"
                            style="color: #667eea;">halaman utama</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
