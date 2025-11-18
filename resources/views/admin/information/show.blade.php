@extends('layouts.main')

@section('title', 'Detail Informasi')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Informasi</h4>
        <a href="{{ route('admin.information.index') }}" class="btn btn-secondary">
            <i data-feather="arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Detail Informasi -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Detail Informasi</h5>
        </div>
        <div class="card-body">
            @if ($information->cover_image)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $information->cover_image) }}" alt="{{ $information->title }}"
                        class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Nomor ID</label>
                        <p class="mb-0">{{ $information->id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Kategori</label>
                        <p class="mb-0">{{ $information->category->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Judul Informasi</label>
                <p class="h5 mb-0">{{ $information->title }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Isi Konten</label>
                <div class="border rounded p-3 bg-light">
                    {!! nl2br(e($information->content)) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Tanggal Dibuat</label>
                        <p class="mb-0">{{ $information->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Tanggal Diperbarui</label>
                        <p class="mb-0">{{ $information->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.information.edit', $information->id) }}" class="btn btn-primary">
                    <i data-feather="edit"></i> Edit
                </a>
                <form action="{{ route('admin.information.destroy', $information->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                        <i data-feather="trash-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Card Galeri Gambar -->
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Galeri Gambar</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                <i data-feather="plus"></i> Tambah Gambar
            </button>
        </div>
        <div class="card-body">
            @if ($information->imageContents->count() > 0)
                <div class="row g-3">
                    @foreach ($information->imageContents as $image)
                        <div class="col-lg-2 col-md-3 col-sm-4">
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gambar Galeri"
                                    class="img-fluid rounded mb-2" style="width: 100%; height: 120px; object-fit: cover;">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-outline-primary btn-sm"
                                        onclick="viewImage('{{ asset('storage/' . $image->image_path) }}')"
                                        title="Lihat Detail">
                                        <i data-feather="eye" style="font-size: 14px;"></i> Lihat
                                    </button>
                                    <form action="{{ route('admin.information.gallery.destroy', $image->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')"
                                            title="Hapus Gambar">
                                            <i data-feather="trash-2" style="font-size: 14px;"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i data-feather="image" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
                    <p class="text-muted">Belum ada gambar galeri.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah Gambar Galeri -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGalleryModalLabel">Tambah Gambar Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.information.gallery.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="information_id" value="{{ $information->id }}">
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label fw-bold">Pilih Gambar Galeri</label>
                            <input type="file" class="form-control" id="gallery_images" name="gallery_images[]"
                                multiple required accept="image/*">
                            <small class="text-muted">Pilih satu atau beberapa gambar (JPEG, PNG, JPG, GIF, maksimal
                                2MB)</small>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat Gambar -->
    <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImageModalLabel">Detail Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="viewImageSrc" src="" alt="Detail Gambar" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewImage(imageSrc) {
            console.log('Viewing image:', imageSrc);
            document.getElementById('viewImageSrc').src = imageSrc;
            const modalEl = document.getElementById('viewImageModal');
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                // Fallback show modal
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.setAttribute('aria-modal', 'true');
                modalEl.removeAttribute('aria-hidden');
                document.body.classList.add('modal-open');
                let backdrop = document.querySelector('.modal-backdrop');
                if (!backdrop) {
                    backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            }
        }
    </script>
@endsection
