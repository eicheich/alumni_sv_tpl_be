@extends('layouts.guest')

@section('content')
    @include('components.profile-header')

    <div class="container mt-5 mb-5">
        <h1 class="h3 mb-4">Profile Saya</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if (auth('alumni')->user()->photo_profile)
                            <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                                alt="{{ auth('alumni')->user()->name }}" class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 150px; height: 150px;">
                                <i data-feather="user" style="width: 64px; height: 64px; color: white;"></i>
                            </div>
                        @endif
                        <h5 class="card-title">{{ auth('alumni')->user()->name }}</h5>
                        <p class="card-text text-muted small">Alumni TPL</p>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informasi Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Nama</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Email</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Nomor Telepon</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Terdaftar Sejak</p>
                                <p class="fw-bold">{{ auth('alumni')->user()->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (auth('alumni')->user()->alumni)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Data Alumni</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">NIM</p>
                                    <p class="fw-bold">{{ auth('alumni')->user()->alumni->nim }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">Program Studi</p>
                                    <p class="fw-bold">{{ auth('alumni')->user()->alumni->major->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">Tanggal Lahir</p>
                                    <p class="fw-bold">
                                        @if (auth('alumni')->user()->alumni->birthdate)
                                            {{ \Carbon\Carbon::parse(auth('alumni')->user()->alumni->birthdate)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Latar Belakang Pendidikan</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addEducationModal">
                                <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            @if (auth('alumni')->user()->alumni->educationalBackgrounds->count() > 0)
                                @foreach (auth('alumni')->user()->alumni->educationalBackgrounds as $background)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <p class="fw-bold mb-1">{{ $background->degree }}</p>
                                                <p class="mb-1">{{ $background->institution_name }}</p>
                                                <small class="text-muted">
                                                    Tahun masuk {{ $background->entry_year }} •
                                                    Tahun lulus {{ $background->graduation_year }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-link text-primary p-0"
                                                    onclick="editEducation({{ $background->id }}, '{{ $background->institution_name }}', '{{ $background->degree }}', {{ $background->entry_year }}, {{ $background->graduation_year }}, '{{ $background->major }}', '{{ $background->faculty }}')">
                                                    Edit data
                                                </button>
                                                <form
                                                    action="{{ route('alumni.educational-backgrounds.destroy', $background->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Belum ada data latar belakang pendidikan</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Karir</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addCareerModal">
                                <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            @if (auth('alumni')->user()->alumni->careers->count() > 0)
                                @foreach (auth('alumni')->user()->alumni->careers as $career)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <p class="mb-1 text-muted small">Nama pekerjaan</p>
                                                <p class="fw-bold mb-2">{{ $career->position }}</p>
                                                <p class="mb-1 text-muted small">Nama perusahaan</p>
                                                <p class="fw-bold mb-2">{{ $career->company_name }}</p>
                                                <p class="mb-1 text-muted small">Tahun masuk</p>
                                                <p class="fw-bold mb-2">
                                                    {{ \Carbon\Carbon::parse($career->start_date)->format('Y') }}</p>
                                                <p class="mb-1 text-muted small">Status</p>
                                                <p class="fw-bold">
                                                    @if ($career->end_date)
                                                        Tidak aktif
                                                    @else
                                                        Aktif
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-link text-primary p-0"
                                                    onclick="editCareer({{ $career->id }}, '{{ $career->company_name }}', '{{ $career->position }}', '{{ $career->start_date }}', '{{ $career->end_date }}')">
                                                    Edit data
                                                </button>
                                                <form action="{{ route('alumni.careers.destroy', $career->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Belum ada data karir</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Keamanan</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Kelola password dan keamanan akun Anda</p>
                        <a href="{{ route('alumni.change-password-view') }}" class="btn btn-sm btn-primary">
                            <i data-feather="edit" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Ubah Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Latar Belakang Pendidikan -->
    <div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEducationModalLabel">Tambah Latar Belakang Pendidikan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('alumni.educational-backgrounds.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">Nama Institusi</label>
                            <input type="text" class="form-control" id="institution_name" name="institution_name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="degree" class="form-label">Program/Gelar</label>
                            <input type="text" class="form-control" id="degree" name="degree" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="entry_year" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control" id="entry_year" name="entry_year"
                                    min="1900" max="{{ date('Y') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="graduation_year" class="form-label">Tahun Lulus</label>
                                <input type="number" class="form-control" id="graduation_year" name="graduation_year"
                                    min="1900" max="{{ date('Y') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="major" name="major">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="faculty" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="faculty" name="faculty">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Karir -->
    <div class="modal fade" id="addCareerModal" tabindex="-1" aria-labelledby="addCareerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCareerModalLabel">Tambah Data Karir</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('alumni.careers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai <small
                                        class="text-muted">(Opsional)</small></label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                                <small class="text-muted">Kosongkan jika masih bekerja</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Latar Belakang Pendidikan -->
    <div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="editEducationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEducationModalLabel">Edit Latar Belakang Pendidikan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editEducationForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_institution_name" class="form-label">Nama Institusi</label>
                            <input type="text" class="form-control" id="edit_institution_name"
                                name="institution_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_degree" class="form-label">Program/Gelar</label>
                            <input type="text" class="form-control" id="edit_degree" name="degree" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_entry_year" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control" id="edit_entry_year" name="entry_year"
                                    min="1900" max="{{ date('Y') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_graduation_year" class="form-label">Tahun Lulus</label>
                                <input type="number" class="form-control" id="edit_graduation_year"
                                    name="graduation_year" min="1900" max="{{ date('Y') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="edit_major" name="major">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_faculty" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="edit_faculty" name="faculty">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Karir -->
    <div class="modal fade" id="editCareerModal" tabindex="-1" aria-labelledby="editCareerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editCareerModalLabel">Edit Data Karir</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editCareerForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_company_name" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="edit_company_name" name="company_name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_position" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="edit_position" name="position" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_end_date" class="form-label">Tanggal Selesai <small
                                        class="text-muted">(Opsional)</small></label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date">
                                <small class="text-muted">Kosongkan jika masih bekerja</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Function untuk edit education
        function editEducation(id, institutionName, degree, entryYear, graduationYear, major, faculty) {
            document.getElementById('edit_institution_name').value = institutionName;
            document.getElementById('edit_degree').value = degree;
            document.getElementById('edit_entry_year').value = entryYear;
            document.getElementById('edit_graduation_year').value = graduationYear;
            document.getElementById('edit_major').value = major || '';
            document.getElementById('edit_faculty').value = faculty || '';

            document.getElementById('editEducationForm').action = "{{ url('profile/educational-backgrounds') }}/" + id;

            var modal = new bootstrap.Modal(document.getElementById('editEducationModal'));
            modal.show();
        }

        // Function untuk edit career
        function editCareer(id, companyName, position, startDate, endDate) {
            document.getElementById('edit_company_name').value = companyName;
            document.getElementById('edit_position').value = position;
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate || '';

            document.getElementById('editCareerForm').action = "{{ url('profile/careers') }}/" + id;

            var modal = new bootstrap.Modal(document.getElementById('editCareerModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded');
            console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'loaded' : 'not loaded');

            // Test modal manually
            const eduButton = document.querySelector('[data-bs-target="#addEducationModal"]');
            const careerButton = document.querySelector('[data-bs-target="#addCareerModal"]');

            console.log('Education button:', eduButton);
            console.log('Career button:', careerButton);

            // Refresh feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endpush
