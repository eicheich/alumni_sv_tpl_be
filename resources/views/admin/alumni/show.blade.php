@extends('layouts.main')

@section('title', 'Detail Alumni')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary btn-sm">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
            Kembali
        </a>
    </div>

    {{-- Profile Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    @if ($alumni->user->photo_profile)
                        <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}" alt="{{ $alumni->user->name }}"
                            class="img-fluid rounded-circle"
                            style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #f0f0f0;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width: 200px; height: 200px;">
                            <i data-feather="user" style="width: 80px; height: 80px; color: #ccc;"></i>
                        </div>
                    @endif
                </div>

                <div class="col-md-9">
                    <h2 class="mb-1">{{ $alumni->user->name }}</h2>
                    <p class="text-muted mb-3">
                        <span class="badge {{ $alumni->is_active ? 'bg-success' : 'bg-secondary' }} me-2">
                            {{ $alumni->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                        <span class="badge bg-info">{{ $alumni->major->name }}</span>
                    </p>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i data-feather="mail"
                                    style="width: 18px; height: 18px; color: #666; margin-right: 10px; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $alumni->user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i data-feather="hash"
                                    style="width: 18px; height: 18px; color: #666; margin-right: 10px; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">NIM</small>
                                    <span>{{ $alumni->nim }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i data-feather="calendar"
                                    style="width: 18px; height: 18px; color: #666; margin-right: 10px; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Tanggal Lahir</small>
                                    <span>
                                        @if ($alumni->birthdate)
                                            {{ \Carbon\Carbon::parse($alumni->birthdate)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if ($alumni->graduation_year)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i data-feather="award"
                                        style="width: 18px; height: 18px; color: #666; margin-right: 10px; margin-top: 2px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Tahun Lulus</small>
                                        <span>{{ $alumni->graduation_year }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.alumni.edit', $alumni->id) }}" class="btn btn-warning btn-sm">
                            <i data-feather="edit-2" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Edit
                        </a>
                        <form action="{{ route('admin.alumni.destroy', $alumni->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus alumni ini?');">
                                <i data-feather="trash-2" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Educational Background Section --}}
    @if ($alumni->educationalBackgrounds->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Latar Belakang Pendidikan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Institusi</th>
                                <th>Gelar</th>
                                <th>Program Studi</th>
                                <th>Fakultas</th>
                                <th>Tahun Masuk - Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumni->educationalBackgrounds as $edu)
                                <tr>
                                    <td><strong>{{ $edu->institution_name }}</strong></td>
                                    <td>{{ $edu->degree }}</td>
                                    <td>{{ $edu->major }}</td>
                                    <td>{{ $edu->faculty }}</td>
                                    <td>
                                        @if ($edu->entry_year && $edu->graduation_year)
                                            <span class="badge bg-light text-dark">{{ $edu->entry_year }} -
                                                {{ $edu->graduation_year }}</span>
                                        @elseif ($edu->entry_year)
                                            <span class="badge bg-light text-dark">{{ $edu->entry_year }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Career Information Section --}}
    @if ($alumni->career)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i data-feather="briefcase" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Informasi Karir
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1">Perusahaan</small>
                        <h6 class="mb-0">{{ $alumni->career->company_name }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1">Posisi</small>
                        <h6 class="mb-0">{{ $alumni->career->position }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1">Tanggal Mulai</small>
                        <p class="mb-0">
                            <i data-feather="calendar"
                                style="width: 14px; height: 14px; margin-right: 5px; vertical-align: middle;"></i>
                            {{ \Carbon\Carbon::parse($alumni->career->start_date)->format('d M Y') }}
                        </p>
                    </div>
                    @if ($alumni->career->end_date)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">Tanggal Berakhir</small>
                            <p class="mb-0">
                                <i data-feather="calendar"
                                    style="width: 14px; height: 14px; margin-right: 5px; vertical-align: middle;"></i>
                                {{ \Carbon\Carbon::parse($alumni->career->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
