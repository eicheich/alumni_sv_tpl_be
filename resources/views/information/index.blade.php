@extends('layouts.guest')

@section('content')
    @include('components.profile-header')

    <div class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="display-5 fw-bold mb-2">Informasi Umum</h1>
                    <p class="text-muted">Berita, info loker, dan survey SV IPB</p>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('information.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari informasi umum"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="search" style="width: 16px; height: 16px;"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="GET" action="{{ route('information.index') }}">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Information Grid -->
            <div class="row g-4">
                @forelse ($informations as $information)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            @if ($information->cover_image)
                                <img src="{{ asset('storage/' . $information->cover_image) }}" class="card-img-top"
                                    alt="{{ $information->title }}" style="height: 200px; object-fit: cover;">
                            @elseif ($information->imageContents->first())
                                <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                                    class="card-img-top" alt="{{ $information->title }}"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i data-feather="image" style="width: 48px; height: 48px; color: white;"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary mb-2 align-self-start">
                                    {{ $information->category->name ?? 'Umum' }}
                                </span>
                                <h5 class="card-title">{{ Str::limit($information->title, 60) }}</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit(strip_tags($information->content), 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($information->created_at)->diffForHumans() }}
                                    </small>
                                    <a href="{{ route('information.show', $information->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i data-feather="inbox" style="width: 64px; height: 64px; color: #6c757d;"></i>
                            <p class="text-muted mt-3">Belum ada informasi</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($informations->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <nav>
                            {{ $informations->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
