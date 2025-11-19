@extends('layouts.guest')

@section('title', 'Lengkapi Profile Alumni')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 500px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-1">Lengkapi Profile Anda</h2>
                <p class="text-center text-muted mb-4">Atur password dan informasi profile untuk menyelesaikan pendaftaran
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.complete-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">Password harus mengandung kombinasi huruf besar,
                            kecil, angka, dan simbol</small>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <input type="password"
                            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                        @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                            id="phone" name="phone" placeholder="Contoh: 08123456789" value="{{ old('phone') }}"
                            required>
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-lg w-100"
                        style="background-color: #667eea; border-color: #667eea; color: white;">
                        Selesaikan Pendaftaran
                    </button>
                </form>

                <hr class="my-4">

                <div class="alert alert-info" role="alert">
                    <small>
                        <i class="feather icon-info"></i>
                        <strong>Catatan:</strong> Semua field yang ditandai dengan asterisk (*) harus diisi untuk
                        menyelesaikan pendaftaran.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
