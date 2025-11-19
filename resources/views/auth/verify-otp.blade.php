@extends('layouts.guest')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 60vh;">
        <div class="card shadow" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <h2 class="text-center mb-2">Verifikasi OTP</h2>
                <p class="text-center text-muted mb-4">Kami telah mengirimkan kode OTP ke email Anda</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('alumni.verify-otp') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="otp_code" class="form-label">Kode OTP <span class="text-danger">*</span></label>
                        <input type="text" id="otp_code" name="otp_code"
                            class="form-control form-control-lg text-center" placeholder="000000" maxlength="6"
                            pattern="[0-9]{6}" inputmode="numeric" value="{{ old('otp_code') }}" required>
                        <small class="form-text text-muted d-block mt-2">Masukkan kode 6 digit yang telah dikirim ke email
                            Anda</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"
                        style="background-color: #667eea; border-color: #667eea;">
                        Verifikasi OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-2">Belum menerima kode OTP?</p>
                    <a href="{{ route('alumni.validate-data.view') }}" class="text-decoration-none" style="color: #667eea;">
                        Kembali dan kirim ulang
                    </a>
                </div>

                <hr class="my-4">

                <div class="alert alert-info" role="alert">
                    <small>
                        <i class="feather icon-info"></i>
                        <strong>Tips:</strong> Kode OTP akan berlaku selama 10 menit. Jangan bagikan kode ini kepada siapa
                        pun.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
