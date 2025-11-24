@extends('layouts.main')

@section('title', 'Data Alumni')

@section('content')



    <!-- PAGE HEADER -->
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-semibold">Data Alumni</h2>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.alumni.exportExcel') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap flex items-center">
                <i data-feather="download" class="mr-2"></i>
                Ekspor Excel
            </a>
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
                name="year">
                <option value="">Semua Angkatan</option>
                {{-- Asumsikan list angkatan/tahun $years --}}
                {{-- @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach --}}
                {{-- Saya biarkan loop original Anda, tetapi ganti name menjadi 'year' --}}
                @foreach ($majors as $major)
                    <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                        {{ $major->name }}
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

            @if (request('search') || request('major_id') || request('status') !== null)
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
                            <td class="px-4 py-3">{{ $alumnus->user->email }}</td>
                            <td class="px-4 py-3">{{ $alumnus->major->name }}</td>
                            <td class="px-4 py-3 flex gap-2">

                                <!-- view -->
                                <a href="{{ route('admin.alumni.show', $alumnus->id) }}"
                                    class="p-2 rounded hover:bg-blue-100 border border-blue-300" title="View">
                                    <i data-feather="eye" class="text-blue-300"></i>
                                </a>

                                <a href="{{ route('admin.alumni.edit', $alumnus->id) }}"
                                    class="p-2 rounded hover:bg-gray-100 border border-gray-300" title="Edit">
                                    <i data-feather="edit-2" class="text-gray-300"></i>
                                </a>



                                <button type="button" onclick="openDeleteModal({{ $alumnus->id }})"
                                    class="p-2 rounded hover:bg-red-100 border border-red-300" title="Delete">
                                    <i data-feather="trash-2" class="text-red-300"></i>
                                </button>

                                <form id="delete-form-{{ $alumnus->id }}"
                                    action="{{ route('admin.alumni.destroy', $alumnus->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>


                            </td>
                        </tr>

                    @empty
                        <tr class="w-full">
                            <td colspan="7" class="py-4 text-muted text-center">

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
            {{ $alumni->links() }}
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
