@extends('layouts.main')

@section('title', 'Alumni Berprestasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Alumni Berprestasi</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOutstandingAlumniModal">
            <i data-feather="plus" style="width: 16px; height: 16px; margin-right: 5px;"></i>
            Tambah Alumni Berprestasi
        </button>
    </div>

    {{-- Search Section --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.outstanding-alumni.index') }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text" class="form-control" name="search"
                        placeholder="Cari nama alumni atau penghargaan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-feather="search" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                        Cari
                    </button>
                </div>
                @if (request('search'))
                    <div class="col-12">
                        <a href="{{ route('admin.outstanding-alumni.index') }}" class="btn btn-secondary btn-sm">
                            <i data-feather="x" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Results Info --}}
    <div class="mb-2">
        <small class="text-muted">
            Menampilkan {{ $outstandingAlumni->firstItem() ?? 0 }} sampai {{ $outstandingAlumni->lastItem() ?? 0 }} dari
            {{ $outstandingAlumni->total() }}
            alumni berprestasi
        </small>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Alumni</th>
                        <th>Jurusan</th>
                        <th>Penghargaan</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outstandingAlumni as $key => $item)
                        <tr>
                            <td class="text-center">{{ $outstandingAlumni->firstItem() + $key }}</td>
                            <td>{{ $item->alumni->user->name }}</td>
                            <td>{{ $item->alumni->major->name }}</td>
                            <td>{{ $item->award_title }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.outstanding-alumni.edit', $item->id) }}"
                                        class="btn btn-outline-primary btn-sm" title="Edit">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('admin.outstanding-alumni.destroy', $item->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete"
                                            onclick="return confirm('Apakah Anda yakin?');">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i data-feather="inbox" style="width: 32px; height: 32px; margin-bottom: 10px;"></i>
                                <p class="mb-0">Tidak ada alumni berprestasi ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $outstandingAlumni->links() }}
    </div>

    <!-- Modal Add Outstanding Alumni -->
    <div class="modal fade" id="addOutstandingAlumniModal" tabindex="-1" aria-labelledby="addOutstandingAlumniModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOutstandingAlumniModalLabel">Tambah Alumni Berprestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-lg" id="alumniSearch"
                            placeholder="Cari alumni...">
                    </div>

                    <!-- Alumni Cards -->
                    <div id="alumniCardsContainer" class="row g-3 mb-4" style="max-height: 400px; overflow-y: auto;">
                        @forelse ($availableAlumni as $alumni)
                            <div class="col-md-6 alumni-card-wrapper"
                                data-alumni-name="{{ strtolower($alumni->user->name) }}">
                                <div class="card border cursor-pointer alumni-card"
                                    style="cursor: pointer; transition: all 0.3s ease;"
                                    data-alumni-id="{{ $alumni->id }}" data-alumni-name="{{ $alumni->user->name }}"
                                    onclick="selectAlumni({{ $alumni->id }}, '{{ addslashes($alumni->user->name) }}')">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            @if ($alumni->user->photo_profile)
                                                <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}"
                                                    alt="{{ $alumni->user->name }}" class="rounded-circle me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 50px; height: 50px;">
                                                    <i data-feather="user"
                                                        style="width: 24px; height: 24px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $alumni->user->name }}</h6>
                                                <small class="text-muted d-block">{{ $alumni->major->name }}</small>
                                                <small class="text-muted d-block">NIM: {{ $alumni->nim }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                <i data-feather="inbox" style="width: 32px; height: 32px; margin-bottom: 10px;"></i>
                                <p class="mb-0">Tidak ada alumni tersedia</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Form (Hidden) -->
                    <form action="{{ route('admin.outstanding-alumni.store') }}" method="POST" id="addOutstandingForm">
                        @csrf
                        <input type="hidden" id="selectedAlumniId" name="alumni_id" value="{{ old('alumni_id') }}">

                        <div class="alert alert-info" id="selectedAlumniAlert" style="display: none;">
                            <strong id="selectedAlumniName"></strong> telah dipilih
                        </div>

                        <div class="mb-3">
                            <label for="award_title" class="form-label">Penghargaan / Prestasi</label>
                            <input type="text" class="form-control @error('award_title') is-invalid @enderror"
                                id="award_title" name="award_title" value="{{ old('award_title') }}"
                                placeholder="Masukkan penghargaan atau prestasi..." required>
                            @error('award_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i data-feather="save" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                                Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function selectAlumni(alumniId, alumniName) {
            // Set hidden input value
            document.getElementById('selectedAlumniId').value = alumniId;

            // Show selected alert
            document.getElementById('selectedAlumniName').textContent = alumniName;
            document.getElementById('selectedAlumniAlert').style.display = 'block';

            // Enable submit button
            document.getElementById('submitBtn').disabled = false;

            // Highlight selected card
            document.querySelectorAll('.alumni-card').forEach(card => {
                card.style.borderColor = '';
                card.style.backgroundColor = '';
            });
            event.currentTarget.style.borderColor = '#0d6efd';
            event.currentTarget.style.borderWidth = '2px';
            event.currentTarget.style.backgroundColor = '#f0f7ff';
        }

        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            // Search functionality
            const searchInput = document.getElementById('alumniSearch');
            const alumniCards = document.querySelectorAll('.alumni-card-wrapper');

            searchInput.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                alumniCards.forEach(card => {
                    const alumniName = card.getAttribute('data-alumni-name');
                    if (alumniName.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Auto-open modal when validation errors are present
            @if ($errors->any() || session()->hasOldInput())
                const modalEl = document.getElementById('addOutstandingAlumniModal');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                }
            @endif
        });
    </script>
@endpush
