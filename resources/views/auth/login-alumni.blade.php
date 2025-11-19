@extends('layouts.guest')

@section('title', 'Login Alumni')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-1">Masuk Alumni TPL</h2>
                <p class="text-center text-muted mb-4">Gunakan email dan password Anda untuk masuk</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.login') }}" method="POST">
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
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-lg w-100"
                        style="background-color: #667eea; border-color: #667eea; color: white;">
                        Masuk
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('alumni.forgot-password-view') }}" class="text-decoration-none text-muted small">
                        Lupa password?
                    </a>
                </div>

                <div class="text-center mt-4">
                    <p class="mb-2">Belum punya akun?</p>
                    <a href="{{ route('alumni.validate-data.view') }}" class="text-decoration-none" style="color: #667eea;">
                        Daftar di sini
                    </a>
                </div>

                <hr class="my-4">

                <div class="alert alert-info" role="alert">
                    <small>
                        <i class="feather icon-info"></i>
                        <strong>Tips:</strong> Pastikan Anda menggunakan email dan password yang benar.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
