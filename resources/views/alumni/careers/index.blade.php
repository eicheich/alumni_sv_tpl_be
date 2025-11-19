@extends('layouts.guest')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Karir</h5>
                        @if ($careers->isEmpty())
                            <a href="{{ route('alumni.careers.create') }}" class="btn btn-light btn-sm">
                                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Tambah
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($careers->isEmpty())
                            <div class="text-center py-5">
                                <i data-feather="inbox" style="width: 48px; height: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-3">Belum ada data karir</p>
                            </div>
                        @else
                            @foreach ($careers as $career)
                                <div class="card mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h6 class="card-title fw-bold">{{ $career->position }}</h6>
                                                <p class="card-text text-muted mb-2">{{ $career->company_name }}</p>
                                                <small class="text-secondary">
                                                    {{ \Carbon\Carbon::parse($career->start_date)->format('M Y') }} -
                                                    @if ($career->end_date)
                                                        {{ \Carbon\Carbon::parse($career->end_date)->format('M Y') }}
                                                    @else
                                                        <span class="badge bg-success">Sekarang</span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <a href="{{ route('alumni.careers.edit', $career->id) }}"
                                                    class="btn btn-sm btn-warning me-2">
                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                <form action="{{ route('alumni.careers.destroy', $career->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin?')">
                                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
