@extends('layouts.main')

@section('title', 'Detail Informasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Detail Informasi</h6>
        <a href="{{ route('admin.information.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($information->cover_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $information->cover_image) }}" alt="{{ $information->title }}"
                        class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">ID</label>
                <p>{{ $information->id }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Judul</label>
                <p>{{ $information->title }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <p>{{ $information->informationCategory->name ?? 'N/A' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Konten</label>
                <div class="border rounded p-3" style="background-color: #f8f9fa;">
                    {!! nl2br(e($information->content)) !!}
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Dibuat pada</label>
                <p>{{ $information->created_at->format('d M Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Diperbarui pada</label>
                <p>{{ $information->updated_at->format('d M Y H:i') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.information.edit', $information->id) }}" class="btn btn-primary btn-sm">
                    <i data-feather="edit"></i> Edit
                </a>
                <form action="{{ route('admin.information.destroy', $information->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                        <i data-feather="trash-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
