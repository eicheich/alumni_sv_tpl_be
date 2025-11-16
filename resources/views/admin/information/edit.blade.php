@extends('layouts.main')

@section('title', 'Edit Informasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Edit Informasi</h6>
        <a href="{{ route('admin.information.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.information.update', $information->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $information->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="information_category_id" class="form-label">Kategori</label>
                    <select class="form-control @error('information_category_id') is-invalid @enderror"
                        id="information_category_id" name="information_category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($informationCategories ?? [] as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('information_category_id', $information->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('information_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5"
                        required>{{ old('content', $information->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($information->cover_image)
                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $information->cover_image) }}" alt="{{ $information->title }}"
                                class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Baru (Opsional)</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                        name="photo">
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.information.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
