@extends('layouts.guest')

@section('content')
    @include('components.profile-header')

    <div class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('information.index') }}">Informasi Umum</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($information->title, 50) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <!-- Category Badge -->
                            <span class="badge bg-primary mb-3">
                                {{ $information->category->name ?? 'Umum' }}
                            </span>

                            <!-- Title -->
                            <h1 class="display-6 fw-bold mb-3">{{ $information->title }}</h1>

                            <!-- Meta Info -->
                            <div class="d-flex align-items-center text-muted mb-4">
                                <i data-feather="calendar" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                                <small>{{ \Carbon\Carbon::parse($information->created_at)->format('d F Y') }}</small>
                                <span class="mx-2">•</span>
                                <i data-feather="clock" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                                <small>{{ \Carbon\Carbon::parse($information->created_at)->diffForHumans() }}</small>
                            </div>

                            <!-- Featured Image (Cover Image) -->
                            @if ($information->cover_image)
                                <img src="{{ asset('storage/' . $information->cover_image) }}"
                                    class="img-fluid rounded mb-4 w-100" alt="{{ $information->title }}"
                                    style="max-height: 500px; object-fit: cover;">
                            @elseif ($information->imageContents->first())
                                <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                                    class="img-fluid rounded mb-4 w-100" alt="{{ $information->title }}"
                                    style="max-height: 500px; object-fit: cover;">
                            @endif

                            <!-- Content -->
                            <div class="content" style="line-height: 1.8; font-size: 1.05rem;">
                                {!! nl2br(e($information->content)) !!}
                            </div>

                            <!-- Image Gallery from information_image_content -->
                            @if ($information->imageContents->count() > 0)
                                <div class="mt-5">
                                    <h5 class="mb-3 fw-bold">Galeri Foto</h5>
                                    <div class="row g-3">
                                        @foreach ($information->imageContents as $imageContent)
                                            <div class="col-md-4">
                                                <img src="{{ asset('storage/' . $imageContent->image_path) }}"
                                                    class="img-fluid rounded shadow-sm" alt="Gallery Image"
                                                    style="height: 200px; width: 100%; object-fit: cover; cursor: pointer;"
                                                    onclick="openImageModal('{{ asset('storage/' . $imageContent->image_path) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-3">
                        <a href="{{ route('information.index') }}" class="btn btn-outline-secondary">
                            <i data-feather="arrow-left" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                            Kembali ke Daftar Informasi
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Information -->
                    @if ($relatedInformations->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Informasi Terkait</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach ($relatedInformations as $related)
                                        <a href="{{ route('information.show', $related->id) }}"
                                            class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-start">
                                                @if ($related->imageContents->first())
                                                    <img src="{{ asset('storage/' . $related->imageContents->first()->image_path) }}"
                                                        class="rounded me-3" alt="{{ $related->title }}"
                                                        style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 60px; min-width: 80px;">
                                                        <i data-feather="image"
                                                            style="width: 24px; height: 24px; color: white;"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ Str::limit($related->title, 50) }}</h6>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($related->created_at)->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Category Info -->
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Kategori</h5>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-primary fs-6">
                                {{ $information->category->name ?? 'Umum' }}
                            </span>
                            <div class="mt-3">
                                <a href="{{ route('information.index', ['category' => $information->information_category_id]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Lihat Semua dari Kategori Ini
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="modalImage" src="" class="img-fluid w-100" alt="Preview">
                </div>
            </div>
        </div>
    </div>

    @include('components.landing-footer')

    <script>
        // Function to open image in modal
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            var modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
