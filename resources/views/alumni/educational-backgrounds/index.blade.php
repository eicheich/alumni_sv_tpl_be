@extends('layouts.guest')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Latar Belakang Pendidikan</h5>
                        <a href="{{ route('alumni.educational-backgrounds.create') }}" class="btn btn-light btn-sm">
                            <i data-feather="plus" style="width: 16px; height: 16px;"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($educationalBackgrounds->isEmpty())
                            <div class="text-center py-5">
                                <i data-feather="inbox" style="width: 48px; height: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-3">Belum ada data latar belakang pendidikan</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Institusi</th>
                                            <th>Program/Gelar</th>
                                            <th>Tahun</th>
                                            <th>Jurusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($educationalBackgrounds as $background)
                                            <tr>
                                                <td>
                                                    <strong>{{ $background->institution_name }}</strong>
                                                </td>
                                                <td>{{ $background->degree }}</td>
                                                <td>{{ $background->entry_year }} - {{ $background->graduation_year }}</td>
                                                <td>{{ $background->major ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('alumni.educational-backgrounds.edit', $background->id) }}"
                                                        class="btn btn-sm btn-warning me-2">
                                                        <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('alumni.educational-backgrounds.destroy', $background->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin?')">
                                                            <i data-feather="trash-2"
                                                                style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('alumni.profile') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
@endsection
