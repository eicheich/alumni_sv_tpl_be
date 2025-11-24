@extends('layouts.main')

@section('title', 'Alumni Berprestasi')

@section('content')
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-semibold">Data Alumni</h2>

        <div class="flex items-center gap-3">

            <button onclick="openOutstandingAlumniModal()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap"
                data-modal-target="addAlumniModal">
                Tambah Alumni
            </button>

        </div>
    </div>



    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 w-full">
        <form method="GET" action="{{ route('admin.outstanding-alumni.index') }}"
            class="flex flex-col md:flex-row gap-2 w-full items-center justify-between">

            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                </div>
                <input type="text" placeholder="Cari nama alumni atau penghargaan..." name="search"
                    class="w-full border border-gray-300 rounded-lg py-2 pl-9 pr-3 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                    value="{{ request('search') }}" />
            </div>


            <button type="submit"
                class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap w-full md:w-auto">
                <i data-feather="search" class="h-4 pr-1"></i>
                Filter
            </button>

            @if (request('search'))
                <a href="{{ route('admin.outstanding-alumni.index') }}"
                    class="flex items-center justify-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm whitespace-nowrap w-full md:w-auto">
                    <i data-feather="x" class="w-4 h-4 mr-1"></i>
                    Reset
                </a>
            @endif
        </form>

        {{-- Jika Anda memiliki tombol tambah alumni di luar form filter, tambahkan di sini --}}

    </div>

    <!-- CONTENT CARD WRAPPER -->
    <div class="bg-white p-6 rounded-xl shadow-sm border max-w-5xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">

            <!-- Card 1 -->
            @forelse ($outstandingAlumni as $key => $item)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="h-28 overflow-hidden">
                        <img src="{{ asset('resources/images/wave.svg') }}" class="h-40 w-full object-cover" alt="">
                    </div>
                    <div class="-mt-20 flex justify-center">
                        @if ($item->alumni->user->photo_profile)
                            <img src="{{ asset('storage/' . $item->alumni->user->photo_profile) }}"
                                alt="Photo of {{ $item->alumni->user->name }}"
                                class="rounded-full border-4 border-white w-24 h-24 object-cover">
                        @else
                            N/A
                        @endif
                    </div>
                    <div class="px-6 pb-6 pt-2">
                        <p class="text-xs text-purple-600 font-medium">{{ $item->award_title }}</p>
                        <h3 class="text-lg font-semibold mt-1">{{ $item->alumni->user->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $item->alumni->major->name }}</p>
                        {{-- <p class="text-sm font-medium text-gray-800"><i class="fa-solid me-1 fa-briefcase text-purple-600"></i>Apple Inc.</p> --}}
                        <div class="flex justify-between gap-2">
                            <a href="{{ route('admin.outstanding-alumni.edit', encrypt($item->id)) }}"
                                class="mt-4 bg-purple-600 text-white px-2 py-2 rounded-md text-sm hover:bg-purple-700 flex w-full items-center"
                                title="Edit">
                                <i data-feather="edit-2" class="h-4"></i> Edit
                            </a>


                            <button type="button" onclick="openDeleteModal({{ $item->id }})"
                                class="mt-4 bg-red-600 text-white px-2 py-2 rounded-md text-sm hover:bg-red-700 flex w-full items-center"
                                title="Delete">
                                <i data-feather="trash-2" class="text-red-300"></i>Hapus
                            </button>

                            <form id="delete-form-{{ $item->id }}"
                                action="{{ route('admin.outstanding-alumni.destroy', encrypt($item->id)) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                            </form>


                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl flex justify-center items-center col-span-4">
                    <i data-feather="inbox" class="h-8 me-2"></i>
                    <p>Tidak ada alumni berprestasi ditemukan</p>
                </div>
            @endforelse


        </div>

        <!-- FOOTER TABLE -->
        <div class="flex justify-between items-center text-sm text-gray-600 mt-4">
            <p>Menampilkan 1 dari 1</p>

            <div class="flex items-center gap-2">
                <button class="px-3 py-1 border border-gray-400 rounded hover:bg-gray-100">&lt;</button>
                <button class="px-3 py-1 border border-gray-400 rounded hover:bg-gray-100">&gt;</button>
            </div>
        </div>

        @if ($outstandingAlumni->hasPages())
            <div class="mt-4 flex justify-center">
                {{ $outstandingAlumni->links('components.pagination') }}
            </div>
        @endif

    </div>

    <!-- Tambahkan spacer bawah agar konten tidak mentok ke footer layar -->
    <div class="h-12"></div>















    {{-- modal add alummi --}}
    <div id="addOutstandingAlumniModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50
            flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">

        <div
            class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 transform scale-95 transition-transform duration-300">

            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900" id="addOutstandingAlumniModalLabel">
                    Tambah Alumni Berprestasi
                </h3>
                <button type="button" onclick="closeOutstandingAlumniModal()"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <input type="text" id="alumniSearch" placeholder="Cari alumni..."
                        class="w-full border border-gray-300 rounded-lg py-2 px-4 text-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div id="alumniCardsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6"
                    style="max-height: 400px; overflow-y: auto;">

                    @forelse ($availableAlumni as $alumni)
                        <div class="alumni-card-wrapper" data-alumni-name="{{ strtolower($alumni->user->name) }}">
                            <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer alumni-card
                                        hover:border-purple-500 hover:shadow-md transition duration-300"
                                data-alumni-id="{{ $alumni->id }}" data-alumni-name="{{ $alumni->user->name }}"
                                onclick="selectAlumni({{ $alumni->id }}, '{{ addslashes($alumni->user->name) }}', this)">

                                <div class="flex items-start">
                                    @if ($alumni->user->photo_profile)
                                        <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}"
                                            alt="{{ $alumni->user->name }}" class="rounded-full mr-3"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-gray-100 rounded-full flex items-center justify-center mr-3"
                                            style="width: 50px; height: 50px;">
                                            <i data-feather="user" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <h6 class="text-base font-semibold text-gray-900 mb-0">{{ $alumni->user->name }}
                                        </h6>
                                        <small class="text-gray-500 block">{{ $alumni->major->name }}</small>
                                        <small class="text-gray-500 block">NIM: {{ $alumni->nim }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-6">
                            <i data-feather="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                            <p class="mb-0">Tidak ada alumni tersedia</p>
                        </div>
                    @endforelse
                </div>

                <form action="{{ route('admin.outstanding-alumni.store') }}" method="POST" id="addOutstandingForm">
                    @csrf
                    <input type="hidden" id="selectedAlumniId" name="alumni_id" value="{{ old('alumni_id') }}">

                    <div class="p-3 bg-blue-100 text-blue-800 rounded-lg mb-4" id="selectedAlumniAlert"
                        style="display: none;">
                        <strong id="selectedAlumniName"></strong> telah dipilih
                    </div>

                    <div class="mb-4">
                        <label for="award_title" class="block text-sm font-medium text-gray-700 mb-1">
                            Penghargaan / Prestasi
                        </label>
                        <input type="text" id="award_title" name="award_title" value="{{ old('award_title') }}"
                            placeholder="Masukkan penghargaan atau prestasi..." required
                            class="w-full border border-gray-300 rounded-lg py-2 px-4 text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none
                            @error('award_title') border-red-500 @enderror">
                        @error('award_title')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeOutstandingAlumniModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn" disabled
                            class="flex items-center px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition disabled:opacity-50">
                            <i data-feather="save" class="w-4 h-4 mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

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











    <!-- Modal Add Outstanding Alumni -->
    {{-- <div class="modal fade" id="addOutstandingAlumniModal" tabindex="-1" aria-labelledby="addOutstandingAlumniModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOutstandingAlumniModalLabel">Tambah Alumni Berprestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-lg" id="alumniSearch"
                            placeholder="Cari alumni...">
                    </div>

                    <!-- Alumni Cards -->
                    <div id="alumniCardsContainer" class="row g-3 mb-4" style="max-height: 400px; overflow-y: auto;">
                        @forelse ($availableAlumni as $alumni)
                            <div class="col-md-6 alumni-card-wrapper"
                                data-alumni-name="{{ strtolower($alumni->user->name) }}">
                                <div class="card border cursor-pointer alumni-card"
                                    style="cursor: pointer; transition: all 0.3s ease;"
                                    data-alumni-id="{{ $alumni->id }}" data-alumni-name="{{ $alumni->user->name }}"
                                    onclick="selectAlumni({{ $alumni->id }}, '{{ addslashes($alumni->user->name) }}')">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            @if ($alumni->user->photo_profile)
                                                <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}"
                                                    alt="{{ $alumni->user->name }}" class="rounded-circle me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 50px; height: 50px;">
                                                    <i data-feather="user"
                                                        style="width: 24px; height: 24px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $alumni->user->name }}</h6>
                                                <small class="text-muted d-block">{{ $alumni->major->name }}</small>
                                                <small class="text-muted d-block">NIM: {{ $alumni->nim }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                <i data-feather="inbox" style="width: 32px; height: 32px; margin-bottom: 10px;"></i>
                                <p class="mb-0">Tidak ada alumni tersedia</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Form (Hidden) -->
                    <form action="{{ route('admin.outstanding-alumni.store') }}" method="POST" id="addOutstandingForm">
                        @csrf
                        <input type="hidden" id="selectedAlumniId" name="alumni_id" value="{{ old('alumni_id') }}">

                        <div class="alert alert-info" id="selectedAlumniAlert" style="display: none;">
                            <strong id="selectedAlumniName"></strong> telah dipilih
                        </div>

                        <div class="mb-3">
                            <label for="award_title" class="form-label">Penghargaan / Prestasi</label>
                            <input type="text" class="form-control @error('award_title') is-invalid @enderror"
                                id="award_title" name="award_title" value="{{ old('award_title') }}"
                                placeholder="Masukkan penghargaan atau prestasi..." required>
                            @error('award_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i data-feather="save" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                                Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@push('scripts')
    <script>
        // add alumni modal
        // Inisialisasi variabel
        const modal = document.getElementById('addOutstandingAlumniModal');
        const alumniSearch = document.getElementById('alumniSearch');
        const cardsContainer = document.getElementById('alumniCardsContainer');
        const selectedAlumniIdInput = document.getElementById('selectedAlumniId');
        const selectedAlumniName = document.getElementById('selectedAlumniName');
        const selectedAlumniAlert = document.getElementById('selectedAlumniAlert');
        const submitBtn = document.getElementById('submitBtn');

        // Pastikan feather.replace() dipanggil jika Anda menggunakannya
        // feather.replace();

        // --- FUNGSI MODAL ---

        function openOutstandingAlumniModal() {
            // Hapus opacity-0 dan pointer-events-none untuk menampilkan modal
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            resetSelection();
        }

        function closeOutstandingAlumniModal() {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }

        modal.addEventListener('click', (e) => {
            if (e.target.id === 'addOutstandingAlumniModal') {
                closeOutstandingAlumniModal();
            }
        });

        // --- FUNGSI SELEKSI ALUMNI ---

        // Fungsi untuk menandai alumni terpilih (PENTING: Gunakan 'element' sebagai argumen)
        function selectAlumni(id, name, element) {
            // 1. Hapus kelas terpilih dari semua card
            document.querySelectorAll('.alumni-card').forEach(card => {
                card.classList.remove('border-purple-600', 'ring-2', 'ring-purple-300');
            });

            // 2. Tambahkan kelas terpilih ke card yang diklik
            element.classList.add('border-purple-600', 'ring-2', 'ring-purple-300');

            // 3. Simpan ID dan Tampilkan Nama
            selectedAlumniIdInput.value = id;
            selectedAlumniName.textContent = name;
            selectedAlumniAlert.style.display = 'block';

            // 4. Aktifkan tombol submit
            submitBtn.disabled = false;
        }

        // Fungsi untuk mereset tampilan dan form
        function resetSelection() {
            document.querySelectorAll('.alumni-card').forEach(card => {
                card.classList.remove('border-purple-600', 'ring-2', 'ring-purple-300');
            });
            selectedAlumniIdInput.value = '';
            selectedAlumniAlert.style.display = 'none';
            submitBtn.disabled = true;
        }

        // --- FUNGSI PENCARIAN ---

        alumniSearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.alumni-card-wrapper');

            cards.forEach(wrapper => {
                const alumniName = wrapper.getAttribute('data-alumni-name');

                if (alumniName.includes(searchTerm)) {
                    wrapper.style.display = 'block';
                } else {
                    wrapper.style.display = 'none';
                }
            });
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
