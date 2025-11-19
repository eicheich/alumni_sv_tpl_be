@extends('layouts.main')

@section('title', 'Data Alumni')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Data Alumni</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlumniModal">
            Add Alumni
        </button>
    </div>
    <p>Welcome to the alumni data page!</p>
    {{-- table --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>NIM</th>
                <th>Photo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumni as $key => $alumnus)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $alumnus->user->name }}</td>
                    <td>{{ $alumnus->user->email }}</td>
                    <td>{{ $alumnus->major->name }}</td>
                    <td>{{ $alumnus->nim }}</td>
                    <td>
                        @if ($alumnus->user->photo_profile)
                            <img src="{{ asset('storage/' . $alumnus->user->photo_profile) }}"
                                alt="Photo of {{ $alumnus->user->name }}" width="50" class="rounded">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{-- Action buttons (Edit, Delete) can be added here --}}
                        <button class="btn btn-outline-info btn-sm" title="View">
                            <i data-feather="eye"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm" title="Edit">
                            <i data-feather="edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" title="Delete">
                            <i data-feather="trash-2"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
