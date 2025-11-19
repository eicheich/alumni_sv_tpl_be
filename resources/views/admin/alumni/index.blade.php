@extends('layouts.main')

@section('title', 'Data Alumni')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Data Alumni</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlumniModal">
            <i data-feather="plus" style="width: 16px; height: 16px; margin-right: 5px;"></i>
            Add Alumni
        </button>
    </div>

    {{-- Search & Filter Section --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.alumni.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari nama, email, atau NIM..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="major_id">
                        <option value="">Semua Jurusan</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Aktivasi Akun
                        </option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Aktivasi Akun
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-feather="search" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                        Filter
                    </button>
                </div>
                @if (request('search') || request('major_id') || request('status') !== null)
                    <div class="col-12">
                        <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary btn-sm">
                            <i data-feather="x" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Results Info --}}
    <div class="mb-2">
        <small class="text-muted">
            Menampilkan {{ $alumni->firstItem() ?? 0 }} sampai {{ $alumni->lastItem() ?? 0 }} dari {{ $alumni->total() }}
            alumni
        </small>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 80px;">Foto</th>
                <th>Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>NIM</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alumni as $key => $alumnus)
                <tr>
                    <td class="text-center">{{ $alumni->firstItem() + $key }}</td>
                    <td class="text-center">
                        @if ($alumnus->user->photo_profile)
                            <img src="{{ asset('storage/' . $alumnus->user->photo_profile) }}"
                                alt="Photo of {{ $alumnus->user->name }}" width="50" class="rounded">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $alumnus->user->name }}</td>
                    <td>{{ $alumnus->user->email }}</td>
                    <td>{{ $alumnus->major->name }}</td>
                    <td>{{ $alumnus->nim }}</td>
                    <td>
                        <a href="{{ route('admin.alumni.show', $alumnus->id) }}" class="btn btn-outline-info btn-sm"
                            title="View">
                            <i data-feather="eye"></i>
                        </a>
                        <a href="{{ route('admin.alumni.edit', $alumnus->id) }}" class="btn btn-outline-warning btn-sm"
                            title="Edit">
                            <i data-feather="edit-2"></i>
                        </a>
                        <form action="{{ route('admin.alumni.destroy', $alumnus->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete"
                                onclick="return confirm('Apakah Anda yakin?');">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i data-feather="inbox" style="width: 32px; height: 32px; margin-bottom: 10px;"></i>
                        <p class="mb-0">Tidak ada alumni ditemukan</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $alumni->links() }}
    </div>

    {{-- include reusable add alumni modal --}}
    @include('components.modals.admin-alumni')

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const trigger = document.querySelector('[data-bs-target="#addAlumniModal"]');
                const modalEl = document.getElementById('addAlumniModal');
                // debug info in console to help diagnose
                console.debug('modal-debug:', {
                    trigger: !!trigger,
                    modalEl: !!modalEl,
                    bootstrap: typeof bootstrap !== 'undefined'
                });

                if (!trigger || !modalEl) return;

                // Add explicit click handler that uses Bootstrap's Modal API if available
                trigger.addEventListener('click', function(e) {
                    // If Bootstrap is loaded, use its API
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        try {
                            const m = new bootstrap.Modal(modalEl);
                            m.show();
                            return;
                        } catch (err) {
                            console.error('bootstrap modal show failed', err);
                        }
                    }

                    // Fallback: minimal show by toggling classes/attributes (not full Bootstrap behavior)
                    try {
                        modalEl.classList.add('show');
                        modalEl.style.display = 'block';
                        modalEl.removeAttribute('aria-hidden');
                        modalEl.setAttribute('aria-modal', 'true');
                        document.body.classList.add('modal-open');
                        // add backdrop
                        let backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    } catch (err) {
                        console.error('modal fallback show failed', err);
                    }
                });

                // Auto-open modal when validation errors are present or old input exists
                @if ($errors->any() || session()->hasOldInput())
                    try {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            bootstrap.Modal.getOrCreateInstance(modalEl).show();
                        } else {
                            modalEl.classList.add('show');
                            modalEl.style.display = 'block';
                            modalEl.removeAttribute('aria-hidden');
                            modalEl.setAttribute('aria-modal', 'true');
                            document.body.classList.add('modal-open');
                            let backdrop = document.createElement('div');
                            backdrop.className = 'modal-backdrop fade show';
                            document.body.appendChild(backdrop);
                        }
                    } catch (err) {
                        console.error('auto-open modal failed', err);
                    }
                @endif
            } catch (err) {
                console.error('modal debug init error', err);
            }
        });
    </script>
@endpush
