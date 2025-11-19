@extends('layouts.guest')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Latar Belakang Pendidikan</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('alumni.educational-backgrounds.update', $educationalBackground->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="institution_name" class="form-label">Nama Institusi</label>
                                <input type="text" class="form-control @error('institution_name') is-invalid @enderror"
                                    id="institution_name" name="institution_name"
                                    value="{{ old('institution_name', $educationalBackground->institution_name) }}"
                                    required>
                                @error('institution_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="degree" class="form-label">Program/Gelar</label>
                                <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                    id="degree" name="degree"
                                    value="{{ old('degree', $educationalBackground->degree) }}" required>
                                @error('degree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="entry_year" class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control @error('entry_year') is-invalid @enderror"
                                        id="entry_year" name="entry_year"
                                        value="{{ old('entry_year', $educationalBackground->entry_year) }}" min="1900"
                                        max="{{ date('Y') }}" required>
                                    @error('entry_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="graduation_year" class="form-label">Tahun Lulus</label>
                                    <input type="number"
                                        class="form-control @error('graduation_year') is-invalid @enderror"
                                        id="graduation_year" name="graduation_year"
                                        value="{{ old('graduation_year', $educationalBackground->graduation_year) }}"
                                        min="1900" max="{{ date('Y') }}" required>
                                    @error('graduation_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="major" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control @error('major') is-invalid @enderror"
                                        id="major" name="major"
                                        value="{{ old('major', $educationalBackground->major) }}">
                                    @error('major')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="faculty" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control @error('faculty') is-invalid @enderror"
                                        id="faculty" name="faculty"
                                        value="{{ old('faculty', $educationalBackground->faculty) }}">
                                    @error('faculty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a href="{{ route('alumni.educational-backgrounds') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
