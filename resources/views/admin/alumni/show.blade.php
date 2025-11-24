@extends('layouts.main')

@section('title', 'Detail Alumni')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.alumni.index') }}"
            class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150">

            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>

            Kembali
        </a>
    </div>
    <section id="informasi" class="bg-gray-100">
        <div class="lg:col-span-2 space-y-6">

            <div class="relative p-6 bg-white rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-xl font-bold text-gray-800">Detail pengguna</h2>


                    <div class="flex space-x-2">

                        <a href="{{ route('admin.alumni.edit', encrypt($alumni->id)) }}"
                            class="bg-violet-600 hover:bg-violet-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition duration-150 flex items-center">
                            <i data-feather="edit-2" class="text-gray-300 mr-1 w-4"></i>
                            Ubah data diri
                        </a>


                        <button type="button" onclick="openDeleteModal({{ $alumni->id }})"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition duration-150 flex items-center"
                            title="Delete">
                            <i data-feather="trash-2" class="text-red-300 mr-1 w-4"></i> Hapus profil
                        </button>

                        <form id="delete-form-{{ $alumni->id }}"
                            action="{{ route('admin.alumni.destroy', encrypt($alumni->id)) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                    </div>

                </div>

                <div class="overflow-hidden mb-4">
                    @if ($alumni->user->photo_profile)
                        <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}" alt="{{ $alumni->user->name }}"
                            class="w-24 object-cover rounded-lg">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto">
                            <i data-feather="user" style="width: 80px; height: 80px; color: #ccc;"></i>
                        </div>
                    @endif
                </div>

                <p class="text-gray-600 mb-3 text-sm">
                    <span
                        class="inline-flex items-center
                                py-1 px-2 rounded-full text-xs font-medium
                                mr-2
                                {{ $alumni->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">

                        {{ $alumni->is_active ? 'Sudah Aktivasi Akun' : 'Belum Aktivasi Akun' }}

                    </span>

                    <span
                        class="inline-flex items-center
                                py-1 px-2 rounded-full text-xs font-medium
                                bg-blue-100 text-blue-800">

                        {{ $alumni->major->name }}

                    </span>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">

                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium">{{ $alumni->user->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Nama lengkap</p>
                        <p class="font-medium">{{ $alumni->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">NIM</p>
                        <p class="font-medium">{{ $alumni->nim }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium">
                            @if ($alumni->gender === 'L')
                                Laki-laki
                            @elseif ($alumni->gender === 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal lahir</p>
                        <p class="font-medium">
                            @if ($alumni->birthdate)
                                {{ \Carbon\Carbon::parse($alumni->birthdate)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if ($alumni->career)
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Riwayat karir</h2>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-lg font-semibold mb-1">{{ $alumni->career->company_name }}</p>
                        <p class="text-gray-600">{{ $alumni->career->position }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Tanggal Mulai</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($alumni->career->start_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Status</p>
                                <p class="font-medium text-green-600">
                                    {{ \Carbon\Carbon::parse($alumni->career->end_date)->format('d M Y') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            @if ($alumni->educationalBackgrounds->count() > 0)
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 ">Riwayat pendidikan</h2>
                    </div>

                    @foreach ($alumni->educationalBackgrounds as $edu)
                        <div class="border-t pt-4">
                            <p class="text-lg font-semibold mb-1">{{ $edu->institution_name }}</p>
                            <p class="text-gray-600">{{ $edu->degree }}</p>
                            <p class="text-gray-600">{{ $edu->major }}</p>
                            <p class="text-gray-600 mb-2">{{ $edu->faculty }}</p>

                            <div class="grid grid-cols-2 gap-4 text-sm">

                                @if ($edu->entry_year && $edu->graduation_year)
                                    <div>
                                        <p class="text-gray-500">Tahun masuk</p>
                                        <p class="font-medium">{{ $edu->entry_year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tahun lulus</p>
                                        <p class="font-medium">{{ $edu->graduation_year }}</p>
                                    </div>
                                @elseif ($edu->entry_year)
                                    <div>
                                        <p class="text-gray-500">Tahun masuk</p>
                                        <p class="font-medium">{{ $edu->entry_year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tahun lulus</p>
                                        <p class="font-medium">-</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-gray-500">Tahun masuk</p>
                                        <p class="font-medium">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tahun lulus</p>
                                        <p class="font-medium">-</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </section>












    {{-- delete modal --}}
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













    <script>
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







@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush





















{{-- Profile Header --}}
{{-- <div class="card border-0 shadow-sm mb-4">
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
                            {{ $alumni->is_active ? 'Sudah Aktivasi Akun' : 'Belum Aktivasi Akun' }}
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
                        @if ($alumni->educationalBackgrounds->first() && $alumni->educationalBackgrounds->first()->graduation_year)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i data-feather="award"
                                        style="width: 18px; height: 18px; color: #666; margin-right: 10px; margin-top: 2px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Tahun Lulus</small>
                                        <span>{{ $alumni->educationalBackgrounds->first()->graduation_year }}</span>
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
    </div> --}}

{{-- Educational Background Section --}}
{{-- @if ($alumni->educationalBackgrounds->count() > 0)
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
    @endif --}}

{{-- Career Information Section --}}
{{-- @if ($alumni->career)
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
    @endif --}}
