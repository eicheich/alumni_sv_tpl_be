@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-1">Lupa Password?</h2>
                <p class="text-center text-muted mb-4">Masukkan email Anda untuk mereset password</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.forgot-password') }}" method="POST">
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

                    <button type="submit" class="btn btn-lg w-100"
                        style="background-color: #667eea; border-color: #667eea; color: white;">
                        Kirim OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-2">Ingat password?</p>
                    <a href="{{ route('alumni.login.view') }}" class="text-decoration-none" style="color: #667eea;">
                        Masuk di sini
                    </a>
                </div>

                <hr class="my-4">

                <div class="alert alert-info" role="alert">
                    <small>
                        <i class="feather icon-info"></i>
                        <strong>Catatan:</strong> Kami akan mengirimkan kode OTP ke email Anda untuk memverifikasi
                        identitas.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
