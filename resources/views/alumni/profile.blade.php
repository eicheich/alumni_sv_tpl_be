@extends('layouts.guest')

@section('content')
    <section id="informasi" class="bg-gray-100 pb-28">
        <div class="grid grid-cols-1 pt-4 md:pt-8 mx-12 lg:grid-cols-3 gap-6">

            {{-- FOTO PROFIL --}}
            <div class="lg:col-span-1 p-4 bg-white rounded-lg shadow-md h-fit">
                <div class="overflow-hidden mb-4 flex justify-center">
                    @if (auth('alumni')->user()->photo_profile)
                        <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                            alt="{{ auth('alumni')->user()->name }}"
                            class="w-48 h-48 object-cover rounded-full" />
                    @else
                        <div class="w-48 h-48 rounded-full bg-gray-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white opacity-70" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A6.002 6.002 0 0112 15c1.657 0 3.156.672 4.243 1.761M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                    Unggah foto profil
                </button>
            </div>

            <div class="lg:col-span-2 space-y-6">

                {{-- DETAIL PENGGUNA --}}
                <div class="relative p-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Detail pengguna</h2>

                        <button id="openModalBtnDataDiri" class="absolute top-4 right-4 bg-violet-600 hover:bg-violet-700 text-white font-semibold py-2 px-4 rounded-lg text-sm">
                            Ubah data diri
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">

                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-medium">{{ auth('alumni')->user()->email }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Pendidikan terakhir</p>
                            <p class="font-medium">
                                {{ auth('alumni')->user()->alumni->degree ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Nama lengkap</p>
                            <p class="font-medium">{{ auth('alumni')->user()->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Pekerjaan sekarang</p>
                            <p class="font-medium">
                                {{ auth('alumni')->user()->alumni->careers->where('end_date', null)->first()->position ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">NIM</p>
                            <p class="font-medium">
                                {{ auth('alumni')->user()->alumni->nim ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Tanggal lahir</p>
                            <p class="font-medium">
                                @if (auth('alumni')->user()->alumni->birthdate)
                                    {{ \Carbon\Carbon::parse(auth('alumni')->user()->alumni->birthdate)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                    </div>
                </div>

                {{-- RIWAYAT KARIR --}}
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Riwayat karir</h2>

                        <button id="btnAddCareerModal" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-4 rounded-lg text-sm">
                            Tambah riwayat karir
                        </button>
                    </div>

                    <div class="border-t pt-4">

                        @if (auth('alumni')->user()->alumni && auth('alumni')->user()->alumni->careers->count() > 0)

                            @foreach (auth('alumni')->user()->alumni->careers as $career)

                                <p class="text-lg font-semibold mb-1">{{ $career->position }}</p>
                                <p class="text-gray-600 mb-2">{{ $career->company_name }}</p>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Tahun masuk</p>
                                        <p class="font-medium">
                                            {{ \Carbon\Carbon::parse($career->start_date)->format('Y') }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-gray-500">{{ $career->end_date ? 'Tahun keluar' : 'Status' }}</p>
                                        <p class="font-medium {{ $career->end_date ? '' : 'text-green-600' }}">
                                            {{ $career->end_date ? \Carbon\Carbon::parse($career->end_date)->format('Y') : 'Aktif' }}
                                        </p>
                                    </div>
                                </div>

                                <button class="text-indigo-600 hover:text-indigo-800 border border-indigo-300 p-2 rounded text-xs mt-2"
                                onclick="openEditCareerModal({
                                    company_name: '{{ $career->company_name }}',
                                    position: '{{ $career->position }}',
                                    start_date: '{{ $career->start_date }}',
                                    end_date: '{{ $career->end_date }}',
                                    action_url: '{{ route('alumni.careers.update', $career->id) }}'
                                })">
                                    Edit data
                                </button>
                                <button type="button"
                                        onclick="openDeleteModalCarier({{ $career->id }})"
                                        class="p-2 rounded hover:bg-red-100 border border-red-300 text-red-300 text-xs"
                                        title="Delete"> Hapus
                                </button>

                                <form id="delete-form-carier-{{ $career->id }}"
                                    action="{{ route('alumni.careers.destroy', $career->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                @if (!$loop->last)
                                    <div class="border-t my-4"></div>
                                @endif

                            @endforeach

                        @else
                            <p class="text-gray-500">Belum ada data karir</p>
                        @endif

                    </div>
                </div>

                {{-- RIWAYAT PENDIDIKAN --}}
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Riwayat pendidikan</h2>

                        <button id="btnAddEducationModal" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-4 rounded-lg text-sm">
                            Tambah riwayat pendidikan
                        </button>
                    </div>

                    <div class="border-t pt-4">

                        @if (auth('alumni')->user()->alumni && auth('alumni')->user()->alumni->educationalBackgrounds->count() > 0)

                            @foreach (auth('alumni')->user()->alumni->educationalBackgrounds as $edu)

                            <p class="text-lg font-semibold mb-1">{{ $edu->institution_name }}</p>
                            <p class="text-gray-600 mb-1">{{ $edu->degree }}</p>
                            <p class="text-gray-600 mb-1">{{ $edu->major }}</p>
                            <p class="text-gray-600 mb-1">{{ $edu->faculty }}</p>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Tahun masuk</p>
                                        <p class="font-medium">{{ $edu->entry_year }}</p>
                                    </div>

                                    <div>
                                        <p class="text-gray-500">Tahun lulus</p>
                                        <p class="font-medium">{{ $edu->graduation_year }}</p>
                                    </div>
                                </div>

                                <button class="text-indigo-600 hover:text-indigo-800 border border-indigo-300 p-2 rounded text-xs mt-2"
                                onclick="openEditEducationModal({
                                    institution_name: '{{ $edu->institution_name }}',
                                    degree: '{{ $edu->degree }}',
                                    entry_year: '{{ $edu->entry_year }}',
                                    graduation_year: '{{ $edu->graduation_year }}',
                                    major: '{{ $edu->major }}',
                                    faculty: '{{ $edu->faculty }}',
                                    action_url: '{{ route('alumni.educational-backgrounds.update', $edu->id) }}'
                                })">
                                    Edit data
                                </button>
                                <button type="button"
                                        onclick="openDeleteModalEdu({{ $edu->id }})"
                                        class="p-2 rounded hover:bg-red-100 border border-red-300 text-red-300 text-xs"
                                        title="Delete"> Hapus
                                </button>

                                <form id="delete-form-edu-{{ $edu->id }}"
                                    action="{{ route('alumni.educational-backgrounds.destroy', $edu->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                @if (!$loop->last)
                                    <div class="border-t my-4"></div>
                                @endif

                            @endforeach

                        @else
                            <p class="text-gray-500">Belum ada riwayat pendidikan</p>
                        @endif

                    </div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md">
                    <p class="text-gray-500 mb-3">
                        Kelola password dan keamanan akun Anda
                    </p>

                    <a href="{{ route('alumni.change-password-view') }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                        <i data-feather="edit" class="w-4 h-4 mr-2"></i>
                        Ubah Password
                    </a>
                </div>

            </div>

        </div>
    </section>

    @include('components.landing-footer')





{{-- data diri --}}
    <div id="modalDataDiri"
        class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 hidden">
    
        <!-- Modal Box -->
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative">

            <!-- Judul -->
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">
            Ubah Data Diri
            </h2>

            <!-- Form -->
            <form class="space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Nama</label>
                        <input type="text"
                            placeholder="Masukkan nama"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">No Telepon</label>
                        <input type="text"
                            placeholder="cth. 08987788098"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Email</label>
                        <input type="email"
                            placeholder="cth. budiono67@gmail.com"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">NIM</label>
                        <input type="text"
                            placeholder="cth. J0403xxxxxx"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date"
                            placeholder="cth. 20-02-1998"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Jenis Kelamin</label>
                        <select class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                        focus:ring-purple-500 focus:outline-none appearance-none">
                            <option>laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>
                </div>

                

                <!-- Tombol Simpan -->
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" id="closeBtnDataDiri"
                            class="w-full py-2 mt-4 bg-gray-200  
                                    text-black rounded-lg font-medium hover:opacity-90 transition">
                        Batal
                    </button>
            
                    <!-- Tombol Simpan -->
                    <button type="submit"
                            class="w-full py-2 mt-4 bg-purple-600
                                    text-white rounded-lg font-medium hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>


    <!-- Overlay: Tambah Pendidikan -->
    <div id="addEducationModal"
        class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 hidden">

        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative">
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">
                Tambah Latar Belakang Pendidikan
            </h2>

            <form action="{{ route('alumni.educational-backgrounds.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Institusi</label>
                    <input type="text" id="institution_name" name="institution_name"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Program/Gelar</label>
                    <input type="text" id="degree" name="degree"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tahun Masuk</label>
                        <input type="number" id="entry_year" name="entry_year"
                            min="1900" max="{{ date('Y') }}"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tahun Lulus</label>
                        <input type="number" id="graduation_year" name="graduation_year"
                            min="1900" max="{{ date('Y') }}"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Jurusan</label>
                        <input type="text" id="major" name="major"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fakultas</label>
                        <input type="text" id="faculty" name="faculty"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button type="button"
                        class="w-full py-2 bg-gray-200 rounded-lg font-medium hover:opacity-90 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="w-full py-2 bg-purple-600  text-white rounded-lg font-medium hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>



    <div id="addCareerModal"
        class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 hidden">

        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative">
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">
                Tambah Riwayat Karir
            </h2>

            <form action="{{ route('alumni.careers.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Perusahaan</label>
                    <input type="text" id="company_name" name="company_name"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Posisi</label>
                    <input type="text" id="position" name="position"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                        <p class="text-xs text-gray-500">Kosongkan jika masih bekerja</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button type="button"
                        class="w-full py-2 bg-gray-200 rounded-lg font-medium hover:opacity-90 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="w-full py-2 bg-purple-600 text-white rounded-lg font-medium hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>



    <div id="editEducationModal"
    class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 hidden">

        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative">
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">
                Edit Latar Belakang Pendidikan
            </h2>

            <form id="editEducationForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Institusi</label>
                    <input type="text" id="edit_institution_name" name="institution_name"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Program/Gelar</label>
                    <input type="text" id="edit_degree" name="degree"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tahun Masuk</label>
                        <input type="number" id="edit_entry_year" name="entry_year"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tahun Lulus</label>
                        <input type="number" id="edit_graduation_year" name="graduation_year"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Jurusan</label>
                        <input type="text" id="edit_major" name="major"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fakultas</label>
                        <input type="text" id="edit_faculty" name="faculty"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button type="button"
                        class="w-full py-2 bg-gray-200 rounded-lg font-medium hover:opacity-90 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="w-full py-2 bg-purple-600  text-white rounded-lg font-medium hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>




    <div id="editCareerModal"
        class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 hidden">

        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative">
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">
                Edit Riwayat Karir
            </h2>

            <form id="editCareerForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Perusahaan</label>
                    <input type="text" id="edit_company_name" name="company_name"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Posisi</label>
                    <input type="text" id="edit_position" name="position"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" id="edit_start_date" name="start_date"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" id="edit_end_date" name="end_date"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                        <p class="text-xs text-gray-500">Kosongkan jika masih bekerja</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button type="button"
                        class="w-full py-2 bg-gray-200 rounded-lg font-medium hover:opacity-90 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="w-full py-2 bg-purple-600  
                        text-white rounded-lg font-medium hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>






        <div id="delete-modal-edu"
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
                    <button onclick="closeDeleteModalEdu()"
                            class="flex-1 py-2 text-gray-700 bg-gray-200 rounded-lg font-medium hover:bg-gray-300 transition">
                        Batal
                    </button>

                    <button onclick="submitDeleteFormEdu()"
                            class="flex-1 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Ya, Hapus!
                    </button>
                </div>

            </div>
        </div>


        <div id="delete-modal-carier"
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
                    <button onclick="closeDeleteModalCarier()"
                            class="flex-1 py-2 text-gray-700 bg-gray-200 rounded-lg font-medium hover:bg-gray-300 transition">
                        Batal
                    </button>

                    <button onclick="submitDeleteFormCarier()"
                            class="flex-1 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Ya, Hapus!
                    </button>
                </div>

            </div>
        </div>











    <!-- Modal Tambah Latar Belakang Pendidikan -->
    {{-- <div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel"
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
    </div> --}}

    <!-- Modal Tambah Data Karir -->
    {{-- <div class="modal fade" id="addCareerModal" tabindex="-1" aria-labelledby="addCareerModalLabel"
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
    </div> --}}

    <!-- Modal Edit Latar Belakang Pendidikan -->
    {{-- <div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="editEducationModalLabel"
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
    </div> --}}

    <!-- Modal Edit Data Karir -->
    {{-- <div class="modal fade" id="editCareerModal" tabindex="-1" aria-labelledby="editCareerModalLabel"
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
    </div> --}}
@endsection

@push('scripts')
    <script>
        // === GENERIC OPEN/CLOSE SYSTEM ===

        // Fungsi untuk membuka modal
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove("hidden");
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add("hidden");
        }

        // ==== DATA DIRI ====
        document.getElementById("openModalBtnDataDiri")?.addEventListener("click", () => {
            openModal("modalDataDiri");
        });
        document.getElementById("closeBtnDataDiri")?.addEventListener("click", () => {
            closeModal("modalDataDiri");
        });

        // ==== ADD EDUCATION ====
        document.getElementById("btnAddEducationModal")?.addEventListener("click", () => {
            openModal("addEducationModal");
        });
        document.querySelector("#addEducationModal button[type='button']")?.addEventListener("click", () => {
            closeModal("addEducationModal");
            btnAddEducationModal.classList.remove("hidden");
        });
        
        // ==== ADD CAREER ====
        document.getElementById("btnAddCareerModal")?.addEventListener("click", () => {
            openModal("addCareerModal");
        });
        document.querySelector("#addCareerModal button[type='button']")?.addEventListener("click", () => {
            closeModal("addCareerModal");
            btnAddCareerModal.classList.remove("hidden");
        });

        // ==== EDIT EDUCATION ====
        function openEditEducationModal(data) {
            openModal("editEducationModal");
            // Isi form otomatis (optional)
            document.getElementById("edit_institution_name").value = data.institution_name;
            document.getElementById("edit_degree").value = data.degree;
            document.getElementById("edit_entry_year").value = data.entry_year;
            document.getElementById("edit_graduation_year").value = data.graduation_year;
            document.getElementById("edit_major").value = data.major;
            document.getElementById("edit_faculty").value = data.faculty;

            // Set action form
            document.getElementById("editEducationForm").action = data.action_url;
        }
        document.querySelector("#editEducationModal button[type='button']")?.addEventListener("click", () => {
            closeModal("editEducationModal");
        });

        // ==== EDIT CAREER ====
        function openEditCareerModal(data) {
            openModal("editCareerModal");

            document.getElementById("edit_company_name").value = data.company_name;
            document.getElementById("edit_position").value = data.position;
            document.getElementById("edit_start_date").value = data.start_date;
            document.getElementById("edit_end_date").value = data.end_date;

            document.getElementById("editCareerForm").action = data.action_url;
        }
        document.querySelector("#editCareerModal button[type='button']")?.addEventListener("click", () => {
            closeModal("editCareerModal");
        });

        // ==== CLOSE MODAL KETIKA KLIK AREA HITAM ====
        document.querySelectorAll("[id$='Modal']").forEach(modal => {
            modal.addEventListener("click", function(e){
                if (e.target === this) closeModal(this.id);
            });
        });








        // delete modal edu
        let deleteFormId = null;

        function openDeleteModalEdu(id) {
            deleteFormId = id;
            document.getElementById('delete-modal-edu').classList.remove('hidden');
        }

        function closeDeleteModalEdu() {
            document.getElementById('delete-modal-edu').classList.add('hidden');
            deleteFormId = null; // clear
        }

        function submitDeleteFormEdu() {
            if (!deleteFormId) return;

            const form = document.getElementById(`delete-form-edu-${deleteFormId}`);
            if (form) {
                form.submit(); // <-- INI YANG MENJAMIN SUBMIT
            }
        }


        // delete modal carier
        let deleteFormIdCarier = null;

        function openDeleteModalCarier(id) {
            deleteFormIdCarier = id;
            document.getElementById('delete-modal-carier').classList.remove('hidden');
        }

        function closeDeleteModalCarier() {
            document.getElementById('delete-modal-carier').classList.add('hidden');
            deleteFormIdCarier = null; // clear
        }

        function submitDeleteFormCarier() {
            if (!deleteFormIdCarier) return;

            const form = document.getElementById(`delete-form-carier-${deleteFormIdCarier}`);
            if (form) {
                form.submit(); // <-- INI YANG MENJAMIN SUBMIT
            }
        }
    </script>


@endpush
