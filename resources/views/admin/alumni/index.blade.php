@extends('layouts.main')

@section('title', 'Data Alumni')

@section('content')



    <!-- PAGE HEADER -->
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-semibold">Data Alumni</h2>

        <div class="flex items-center gap-3">
            <button
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap flex items-center"
                data-modal-target="exportModal">
                <i data-feather="download" class="mr-2"></i>
                Ekspor Excel
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap"
                data-modal-target="addAlumniModal">
                Tambah Alumni
            </button>
        </div>
    </div>



    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 w-full">
        <form method="GET" action="{{ route('admin.alumni.index') }}"
            class="flex flex-col md:flex-row gap-2 w-full items-center justify-between">

            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                </div>
                <input type="text" placeholder="Cari nama, email, atau NIM..." name="search"
                    class="w-full border border-gray-300 rounded-lg py-2 pl-9 pr-3 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                    value="{{ request('search') }}" />
            </div>

            <select
                class="w-full md:w-2/3 border border-gray-300 rounded-lg py-2 px-2 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                name="major_id">
                <option value="" class="text-sm">Semua Jurusan</option>
                @foreach ($majors as $major)
                    <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                        {{ $major->name }}
                    </option>
                @endforeach
            </select>

            <select
                class="w-full md:w-2/3 border border-gray-300 rounded-lg py-2 px-2 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                name="angkatan">
                <option value="">Semua Angkatan</option>
                @foreach ($angkatans as $angkatan)
                    <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                        {{ $angkatan }}
                    </option>
                @endforeach
            </select>

            <select
                class="w-full md:w-2/3 border border-gray-300 rounded-lg py-2 px-2 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                name="status">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Aktivasi Akun</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Aktivasi Akun</option>
            </select>

            <button type="submit"
                class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap w-full md:w-auto">
                <i data-feather="search" class="h-4 pr-1"></i>
                Filter
            </button>

            @if (request('search') || request('major_id') || request('angkatan') || request('status') !== null)
                <a href="{{ route('admin.alumni.index') }}"
                    class="flex items-center justify-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm whitespace-nowrap w-full md:w-auto">
                    <i data-feather="x" class="w-4 h-4 mr-1"></i>
                    Reset
                </a>
            @endif
        </form>

        {{-- Jika Anda memiliki tombol tambah alumni di luar form filter, tambahkan di sini --}}

    </div>


    <!-- CONTENT CARD WRAPPER -->
    <div class="bg-white p-6 rounded-xl shadow-sm border mx-auto">

        <!-- TABEL WRAPPER (scroll mobile) -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-sm border">
            <table class="min-w-full text-sm">
                <thead class="bg-grey text-gray-600 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Foto profil</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">NIM</th>
                        <th class="px-4 py-3 text-left">Angkatan</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Jurusan</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($alumni as $key => $alumnus)
                        <!-- ROW 1 -->
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $alumni->firstItem() + $key }}</td>
                            <td class="px-4 py-3">
                                @if ($alumnus->user->photo_profile)
                                    <img src="{{ asset('storage/' . $alumnus->user->photo_profile) }}"
                                        alt="Photo of {{ $alumnus->user->name }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $alumnus->user->name }}</td>
                            <td class="px-4 py-3">{{ $alumnus->nim }}</td>
                            <td class="px-4 py-3">{{ $alumnus->angkatan }}</td>
                            <td class="px-4 py-3">{{ $alumnus->user->email }}</td>
                            <td class="px-4 py-3">{{ $alumnus->major->name }}</td>
                            <td class="px-4 py-3 flex gap-2">

                                <!-- view -->
                                <a href="{{ route('admin.alumni.show', encrypt($alumnus->id)) }}"
                                    class="p-2 rounded hover:bg-blue-100 border border-blue-300" title="View">
                                    <i data-feather="eye" class="text-blue-300"></i>
                                </a>

                                <a href="{{ route('admin.alumni.edit', encrypt($alumnus->id)) }}"
                                    class="p-2 rounded hover:bg-gray-100 border border-gray-300" title="Edit">
                                    <i data-feather="edit-2" class="text-gray-300"></i>
                                </a>



                                <button type="button" onclick="openDeleteModal({{ $alumnus->id }})"
                                    class="p-2 rounded hover:bg-red-100 border border-red-300" title="Delete">
                                    <i data-feather="trash-2" class="text-red-300"></i>
                                </button>

                                <form id="delete-form-{{ $alumnus->id }}"
                                    action="{{ route('admin.alumni.destroy', encrypt($alumnus->id)) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>


                            </td>
                        </tr>

                    @empty
                        <tr class="w-full">
                            <td colspan="8" class="py-4 text-muted text-center">

                                <div class="inline-flex items-center justify-center">
                                    <i data-feather="inbox" class="mr-2"></i>
                                    <p class="mb-0">Tidak ada alumni ditemukan</p>
                                </div>

                            </td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
        </div>

        <!-- FOOTER TABLE -->
        <div class="flex justify-between items-center text-sm text-gray-600 mt-4">
            <p>Menampilkan 1 dari 1</p>

            <div class="flex items-center gap-2">
                <button class="px-3 py-1 border border-gray-400 rounded hover:bg-gray-100">&lt;</button>
                <button class="px-3 py-1 border border-gray-400 rounded hover:bg-gray-100">&gt;</button>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $alumni->links('components.pagination') }}
        </div>


    </div>











    {{-- modal delete --}}
    <!-- Tambahkan spacer bawah agar konten tidak mentok ke footer layar -->
    <div class="h-12"></div>


    <div id="delete-modal"
        class="fixed inset-0 bg-black/50 hidden bg-black bg-opacity-50 backdrop-blur-sm z-99
                    flex items-center justify-center pointer-events transition duration-300">

        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm transform scale-95 transition duration-300">

            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i data-feather="alert-triangle" class="w-8 h-8 text-red-600"></i>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">Apakah Anda Yakin?</h3>
                <p class="text-sm text-gray-600 text-center mb-6">
                    Data yang telah dihapus tidak dapat dikembalikan!
                </p>
            </div>

            <div class="flex justify-between space-x-4">
                <button onclick="closeDeleteModal()"
                    class="flex-1 py-2 text-gray-700 bg-gray-200 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </button>

                <button onclick="submitDeleteForm()"
                    class="flex-1 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                    Ya, Hapus!
                </button>
            </div>

        </div>
    </div>








    {{-- include reusable add alumni modal --}}
    @include('components.modals.admin-alumni')

    {{-- export modal --}}
    <div id="exportModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition duration-200">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button data-close-modal class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-4 border-b">Ekspor Data Alumni</h2>
            <p class="text-sm text-gray-600 mb-4">Pilih kolom yang ingin Anda ekspor:</p>

            <div class="flex justify-between items-center mb-4">
                <span id="selectedCount" class="text-sm text-gray-600">Dipilih: 6 kolom</span>
                <div class="space-x-2">
                    <button type="button" id="selectAllBtn"
                        class="text-xs text-purple-600 hover:text-purple-800 underline">
                        Pilih Semua
                    </button>
                    <button type="button" id="deselectAllBtn"
                        class="text-xs text-gray-600 hover:text-gray-800 underline">
                        Hapus Semua
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.alumni.exportExcel') }}" method="POST" id="exportForm">
                @csrf

                <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                    <div class="flex items-center">
                        <input type="checkbox" id="field_no" name="fields[]" value="no"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_no" class="ml-2 text-sm text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_nama" name="fields[]" value="nama"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_nama" class="ml-2 text-sm text-gray-700">Nama</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_nim" name="fields[]" value="nim"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_nim" class="ml-2 text-sm text-gray-700">NIM</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_angkatan" name="fields[]" value="angkatan"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_angkatan" class="ml-2 text-sm text-gray-700">Angkatan</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_email" name="fields[]" value="email"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_email" class="ml-2 text-sm text-gray-700">Email</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_jurusan" name="fields[]" value="jurusan"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="field_jurusan" class="ml-2 text-sm text-gray-700">Jurusan</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_jenis_kelamin" name="fields[]" value="jenis_kelamin"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="field_jenis_kelamin" class="ml-2 text-sm text-gray-700">Jenis Kelamin</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_tanggal_lahir" name="fields[]" value="tanggal_lahir"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="field_tanggal_lahir" class="ml-2 text-sm text-gray-700">Tanggal Lahir</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_tahun_lulus" name="fields[]" value="tahun_lulus"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="field_tahun_lulus" class="ml-2 text-sm text-gray-700">Tahun Lulus</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="field_status_aktivasi" name="fields[]" value="status_aktivasi"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="field_status_aktivasi" class="ml-2 text-sm text-gray-700">Status Aktivasi</label>
                    </div>
                </div>

                <div class="flex justify-between space-x-3">
                    <button data-close-modal type="button"
                        class="flex-1 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit" id="exportBtn"
                        class="flex-1 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">
                        Ekspor
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // add modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addAlumniModal');
            if (!modal) return;

            const showModal = () => {
                modal.classList.remove('opacity-0', 'pointer-events-none');
            };

            const hideModal = () => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            };

            // Trigger open
            document.querySelectorAll('[data-modal-target="addAlumniModal"]').forEach(btn => {
                btn.addEventListener('click', showModal);
            });

            // Close button
            modal.querySelectorAll('[data-close-modal]').forEach(btn => {
                btn.addEventListener('click', hideModal);
            });

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) hideModal();
            });

            // Auto-open modal (Laravel validation)
            @if ($errors->any() || session()->hasOldInput())
                showModal();
            @endif
        });

        // export modal
        document.addEventListener('DOMContentLoaded', function() {
            const exportModal = document.getElementById('exportModal');
            if (!exportModal) return;

            const showExportModal = () => {
                exportModal.classList.remove('opacity-0', 'pointer-events-none');
                updateSelectedCount();
            };

            const hideExportModal = () => {
                exportModal.classList.add('opacity-0', 'pointer-events-none');
            };

            // Trigger open export modal
            document.querySelectorAll('[data-modal-target="exportModal"]').forEach(btn => {
                btn.addEventListener('click', showExportModal);
            });

            // Close button for export modal
            exportModal.querySelectorAll('[data-close-modal]').forEach(btn => {
                btn.addEventListener('click', hideExportModal);
            });

            // Close on backdrop click for export modal
            exportModal.addEventListener('click', function(e) {
                if (e.target === exportModal) hideExportModal();
            });

            // Select All button
            document.getElementById('selectAllBtn').addEventListener('click', function() {
                const checkboxes = exportModal.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateSelectedCount();
            });

            // Deselect All button
            document.getElementById('deselectAllBtn').addEventListener('click', function() {
                const checkboxes = exportModal.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();
            });

            // Update count when checkboxes change
            exportModal.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Form validation
            document.getElementById('exportForm').addEventListener('submit', function(e) {
                const checkedBoxes = exportModal.querySelectorAll('input[type="checkbox"]:checked');
                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 kolom untuk diekspor.');
                    return false;
                }
            });
        });

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('#exportModal input[type="checkbox"]:checked');
            const countElement = document.getElementById('selectedCount');
            const count = checkedBoxes.length;
            countElement.textContent = `Dipilih: ${count} kolom`;
        }

        // delete modal
        let deleteFormId = null;

        function openDeleteModal(id) {
            deleteFormId = id;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            deleteFormId = null; // clear
        }

        function submitDeleteForm() {
            if (!deleteFormId) return;

            const form = document.getElementById(`delete-form-${deleteFormId}`);
            if (form) {
                form.submit(); // <-- INI YANG MENJAMIN SUBMIT
            }
        }
    </script>
@endpush

















{{--

<div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Data Alumni</h1>
        <button type="button" class="btn btn-primary" data-modal-target="addAlumniModal" data-bs-toggle="modal" data-bs-target="#addAlumniModal">
            <i data-feather="plus" style="width: 16px; height: 16px; margin-right: 5px;"></i>
            Add Alumni
        </button>
    </div> --}}

{{-- Search & Filter Section --}}
{{-- <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.alumni.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari nama, email, atau NIM..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="major_id">
                        <option value="" class="text-sm">Semua Jurusan</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-2">
                    <select class="form-select" name="major_id">
                        <option value="">Semua Jurusan</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-2">
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
    </div> --}}

{{-- Results Info --}}
{{-- <div class="mb-2">
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
    </table> --}}

{{-- Pagination --}}
{{-- <div class="d-flex justify-content-center mt-4">
        {{ $alumni->links() }}
    </div> --}}
