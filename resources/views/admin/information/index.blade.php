@extends('layouts.main')

@section('title', 'Informasi')

@section('content')
<h2 class="text-2xl font-semibold">Informasi</h2>
    <div class="flex items-center justify-between mb-6">
    
        <div class="flex flex-col md:flex-row gap-4 pt-4 ">

            <div class="md:w-2/3 w-full">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex justify-between items-center pb-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Informasi</h2>
                        <button type="button" class="bg-blue-600 text-white p-1 rounded-md text-sm hover:bg-blue-700 transition duration-150 ease-in-out" id="openAddInformationModalBtn" title="Tambah Informasi">
                            <i data-feather="plus" class="h-4 w-4"></i>
                        </button>
                    </div>

                    <div class="pt-4">
                        <form method="GET" action="{{ route('admin.information.index') }}" class="mb-4 space-y-3">
                            <div class="flex flex-wrap gap-2">
                                <div class="relative flex-grow">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" class="w-full border border-gray-300 rounded-lg py-2 pl-9 pr-3 text-sm focus:ring-2 focus:ring-purple-300 focus:outline-none"
                                        placeholder="Cari judul atau konten..." value="{{ request('search') }}">
                                </div>


                                <select name="category_id" class="border border-gray-300 p-2 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($informationCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <button type="submit" class="bg-blue-600 text-white p-2 text-sm rounded-md hover:bg-blue-700 transition duration-150 ease-in-out flex items-center gap-1">
                                    <i data-feather="search" class="w-4 h-4"></i> Filter
                                </button>
                                <a href="{{ route('admin.information.index') }}" class="bg-gray-500 text-white p-2 text-sm rounded-md hover:bg-gray-600 transition duration-150 ease-in-out flex items-center gap-1">
                                    <i data-feather="x" class="w-4 h-4"></i> Reset
                                </a>
                            </div>
                        </form>


                        
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 w-full">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @forelse($informations as $key => $info)
                                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg">
                                        
                                        <img src="{{ asset('storage/' .$info->cover_image) }}"
                                            class="h-48 w-full object-cover">
                            
                                        
                                        <div class="p-4">
                                            <p class="text-sm text-purple-600 font-medium mb-1">{{ $info->category->name ?? 'N/A' }}</p>
                            
                                            <h2 class="font-semibold text-gray-900 mb-1">
                                                {{ $info->title }}
                                            </h2>
                            
                                            <p class="text-gray-500 text-sm mb-4 line-clamp-3">
                                                {{ $info->content }}
                                            </p>
                        

                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.information.show', $info->id) }}" class=" bg-blue-600 text-white py-2 rounded-md text-sm hover:bg-purple-700 flex w-full items-center justify-center" title="Edit">
                                                    <i data-feather="eye" class="w-4 mr-1"></i> Lihat
                                                </a>
                                                <a href="{{ route('admin.information.edit', $info->id) }}" class=" bg-purple-600 text-white py-2 rounded-md text-sm hover:bg-purple-700 flex w-full items-center justify-center" title="Edit">
                                                    <i data-feather="edit-2" class="w-4 mr-1"></i> Edit
                                                </a>
    
    
                                                <button type="button"
                                                        onclick="openDeleteModal({{$info->id}})"
                                                        class=" bg-red-600 text-white py-2 rounded-md text-sm hover:bg-red-700 flex w-full items-center justify-center"
                                                        title="Delete"> 
                                                    <i data-feather="trash-2" class="w-4 mr-1"></i>Hapus
                                                </button>
    
                                                <form id="delete-form-{{$info->id}}"
                                                    action="{{ route('admin.information.destroy', $info->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                @empty
                                    <div>Tidak Ada Informasi</div>
                                @endforelse
                            </div>
                            
                            
                        </div>

                                            
                        @if ($informations->hasPages())
                            <div class="mt-4 flex justify-center">
                                {{ $informations->links('vendor.pagination.tailwind') }} 
                                
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <hr class="md:hidden my-4 border-gray-200">





            <div class="md:w-1/3 w-full">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex justify-between items-center pb-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Kategori Informasi</h2>
                        <button type="button" onclick="openModal('addCategoryModal')" class="bg-blue-600 text-white p-1 rounded-md text-sm hover:bg-blue-700 transition duration-150 ease-in-out" title="Tambah Kategori">
                            <i data-feather="plus" class="h-4 w-4"></i>
                        </button>
                    </div>
                    
                    <div class="pt-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($informationCategories ?? [] as $category)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">{{ $category->id }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-1">
                                                    <button type="button"
                                                        class="text-indigo-600 hover:text-indigo-900 p-1 rounded-md border border-indigo-600 hover:bg-indigo-50 text-xs transition duration-150 ease-in-out"
                                                        onclick="openEditModal({{ $category->id }}, '{{ $category->name }}');" title="Edit Kategori">
                                                        <i data-feather="edit" class="w-4 h-4"></i>
                                                    </button>
                                                    
                                                    <button type="button"
                                                        onclick="openDeleteCategoryModal({{ $category->id }}, 'delete-form-category-{{ $category->id }}')" 
                                                        class="text-red-600 hover:text-red-900 p-1 rounded-md border border-red-600 hover:bg-red-50 text-xs transition duration-150 ease-in-out"
                                                        title="Hapus Kategori">
                                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="delete-form-category-{{ $category->id }}"
                                                        action="{{ route('admin.information.category.destroy', $category->id) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-3 py-2 text-center text-sm text-gray-500">Tidak ada data kategori.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            
        </div>






            
            
    </div>

       










    <!-- Modal Tambah Kategori -->
   <div id="addCategoryModal" tabindex="-1" aria-hidden="true" 
    class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full mx-auto p-4 md:p-6 overflow-y-auto">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Kategori
                    </h3>
                    <button type="button" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        onclick="closeModal('addCategoryModal')" aria-label="Close">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-4 md:p-5">
                    <form action="{{ route('admin.information.category.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="add_category_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                            <input type="text" 
                                class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                                id="add_category_name" name="name" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" tabindex="-1" aria-hidden="true" 
    class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full mx-auto p-4 md:p-6 overflow-y-auto">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Kategori
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="editCategoryModal" onclick="closeModal('addCategoryModal')" aria-label="Close">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-4 md:p-5">
                    <form id="edit-category-form" action="" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT') 
                        <div>
                            <label for="edit_category_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                            <input type="text" 
                                class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                                id="edit_category_name" name="name" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- modal hapus kategori --}}

    <div id="deleteCategoryModal" class="fixed inset-0 bg-black/50 hidden bg-black bg-opacity-50 backdrop-blur-sm z-99 
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
                <button id="close-delete-btn" onclick="closeModal('deleteCategoryModal')"
                        class="flex-1 py-2 text-gray-700 bg-gray-200 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </button>
                
                <button id="confirm-delete-btn" 
                        class="flex-1 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                    Ya, Hapus!
                </button>
            </div>
            
        </div>
    </div>














    




    <!-- Modal Tambah Informasi -->
    <div id="addInformationModal" tabindex="-1" aria-hidden="true" 
    class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 overflow-y-auto bg-opacity-50 transition-opacity duration-300">

        <div class="relative w-full max-w-3xl h-full mx-auto p-4 md:p-6">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700">
                
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Informasi
                    </h3>
                    <button type="button" onclick="closeAddInformationModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        aria-label="Close">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-4 md:p-5">
                    <form action="{{ route('admin.information.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="">
                            <input 
                                type="file" 
                                id="photo-upload" name="photo"
                                class="hidden @error('photo') border border-red-500 @enderror"
                                accept="image/*" 
                                onchange="document.getElementById('photo-image-preview').src = window.URL.createObjectURL(this.files[0])"
                            >

                            <label for="photo-upload" 
                                class="relative w-full h-20 overflow-hidden 
                                        border-4 border-gray-300 hover:border-indigo-500 
                                        cursor-pointer bg-gray-100 shadow-md transition duration-300 group">

                                <img id="photo-image-preview" 
                                    src="https://via.placeholder.com/150/f0f0f0?text=Pilih+Foto" 
                                    alt="Pratinjau Foto Cover" 
                                    class="w-full h-full object-cover">

                                <div class="absolute inset-0 bg-black bg-opacity-40 
                                            flex items-center justify-center opacity-30 group-hover:opacity-50 
                                            transition duration-300">
                                    <i data-feather="camera" class="w-8 h-8 text-white"></i>
                                </div>
                            </label>

                            <label for="photo-upload" class="mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium cursor-pointer">
                                Ubah Foto Cover
                            </label>
                            @error('photo')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul</label>
                            <input type="text" 
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="information_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                            <select 
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('information_category_id') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                                id="information_category_id" name="information_category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($informationCategories ?? [] as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('information_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('information_category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konten</label>
                            <textarea 
                                class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('content') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500" 
                                id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        

                        <div class="pt-4 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal hapus info --}}
    <div id="delete-modal" class="fixed inset-0 bg-black/50 hidden bg-black bg-opacity-50 backdrop-blur-sm z-99 
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
        function setEditData(id, name) {
            const form = document.getElementById('editCategoryForm');
            form.action = '{{ route('admin.information.category.update', ':id') }}'.replace(':id', id);
            document.getElementById('edit_name').value = name;
        }






        // modal tambah informasi
        document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addInformationModal');
        const openBtn = document.getElementById('openAddInformationModalBtn');

        openBtn.addEventListener('click', function() {
            openAddInformationModal();
        });

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeAddInformationModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddInformationModal();
            }
        });
    });

    function openAddInformationModal() {
        const modal = document.getElementById('addInformationModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Gunakan 'flex' untuk menampilkan modal
            document.body.classList.add('overflow-hidden'); // Mencegah scrolling body saat modal terbuka
        }
    }

    function closeAddInformationModal() {
        const modal = document.getElementById('addInformationModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden'); 
        }
    }




    // modal hapus info
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















    // 1. FUNGSI UTAMA UNTUK MEMBUKA DAN MENUTUP MODAL

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Menggunakan 'flex' untuk menampilkan dan memposisikan
            document.body.classList.add('overflow-hidden'); // Mencegah scrolling body utama
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden'); 
        }
    }

    // 2. LOGIKA EDIT MODAL

    const BASE_UPDATE_URL = "{{ route('admin.information.category.update', 'REPLACE_ID') }}";

    function openEditModal(id, name) {
        const form = document.getElementById('edit-category-form');
        const nameInput = document.getElementById('edit_category_name');
        
        // 1. Set action URL
        const updateUrl = BASE_UPDATE_URL.replace('REPLACE_ID', id);
        form.setAttribute('action', updateUrl);

        // 2. Set nilai input
        nameInput.value = name;
        
        // 3. Buka Modal
        openModal('editCategoryModal');
    }

    // 3. LOGIKA DELETE MODAL

    function openDeleteCategoryModal(categoryName, formId) {
        // 1. Tampilkan nama kategori yang akan dihapus (Optional: tambahkan elemen span di modal)
        const nameDisplay = document.getElementById('delete-category-name-display');
        if (nameDisplay) {
             nameDisplay.textContent = `(${categoryName})`;
        }

        // 2. Atur tombol konfirmasi untuk submit form yang sesuai
        const confirmBtn = document.getElementById('confirm-delete-btn');
        confirmBtn.onclick = function() {
            document.getElementById(formId).submit();
        };

        // 3. Buka Modal
        openModal('deleteCategoryModal');
    }
    
    // 4. PENUTUPAN MODAL DENGAN KLIK DI LUAR (Overlay)
    
    // Dapatkan semua elemen modal
    const modals = [
        document.getElementById('addCategoryModal'),
        document.getElementById('editCategoryModal'),
        document.getElementById('deleteCategoryModal')
    ];

    modals.forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(event) {
                // Periksa apakah yang diklik adalah area overlay modal (bukan konten di dalamnya)
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        }
    });
    </script>
    

@endsection
