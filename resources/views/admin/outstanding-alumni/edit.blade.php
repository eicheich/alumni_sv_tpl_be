@extends('layouts.main')

@section('title', 'Edit Alumni Berprestasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Edit Alumni Berprestasi</h1>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.outstanding-alumni.update', $outstandingAlumni->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Alumni Info (Read-only) -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alumniName" class="form-label">Nama Alumni</label>
                        <input type="text" class="form-control" id="alumniName"
                            value="{{ $outstandingAlumni->alumni->user->name }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="major" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="major"
                            value="{{ $outstandingAlumni->alumni->major->name }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim"
                            value="{{ $outstandingAlumni->alumni->nim }}" disabled>
                    </div>
                </div>

                <!-- Award Title -->
                <div class="mb-3">
                    <label for="award_title" class="form-label">Penghargaan / Prestasi <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('award_title') is-invalid @enderror" id="award_title"
                        name="award_title" value="{{ old('award_title', $outstandingAlumni->award_title) }}"
                        placeholder="Masukkan penghargaan atau prestasi..." required>
                    @error('award_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.outstanding-alumni.index') }}" class="btn btn-secondary">
                        <i data-feather="x" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
