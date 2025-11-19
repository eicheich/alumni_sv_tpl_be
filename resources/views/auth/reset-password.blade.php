@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
        <div class="card shadow" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-1">Atur Password Baru</h2>
                <p class="text-center text-muted mb-4">Buat password baru untuk akun Anda</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.reset-password') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">Password harus minimal 8 karakter</small>
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

                    <button type="submit" class="btn btn-lg w-100"
                        style="background-color: #667eea; border-color: #667eea; color: white;">
                        Reset Password
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
                        <strong>Catatan:</strong> Password Anda akan diubah setelah submit form ini.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
