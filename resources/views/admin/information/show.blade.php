@extends('layouts.main')

@section('title', 'Detail Informasi')

@section('content')
    <a href="{{ route('admin.information.index') }}" 
    class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150">
        <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
    </a>
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-xl font-semibold text-gray-800">Detail Informasi</h4>
    </div>


    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="p-6">
            @if ($information->cover_image)
                <div class="mb-6 text-center">
                    <img src="{{ asset('storage/' . $information->cover_image) }}" alt="{{ $information->title }}"
                        class="w-full max-h-96 object-cover rounded-lg shadow-lg mx-auto">
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <div class="mb-3">
                        <label class="block text-sm font-bold text-gray-500 mb-1">Nomor ID</label>
                        <p class="text-base text-gray-900">{{ $information->id }}</p>
                    </div>
                </div>
                <div>
                    <div class="mb-3">
                        <label class="block text-sm font-bold text-gray-500 mb-1">Kategori</label>
                        <p class="text-base text-gray-900">{{ $information->category->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-4 border-t pt-4">
                <label class="block text-sm font-bold text-gray-500 mb-1">Judul Informasi</label>
                <p class="text-2xl font-bold text-gray-900">{{ $information->title }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-500 mb-1">Isi Konten</label>
                <div class="border rounded-lg p-4 bg-gray-50 prose max-w-none"> {{-- Menggunakan prose untuk styling konten HTML --}}
                    {!! $information->content !!} {{-- Hapus nl2br(e(...)) karena konten biasanya sudah HTML/rich text --}}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                <div>
                    <div class="mb-3">
                        <label class="block text-sm font-bold text-gray-500 mb-1">Tanggal Dibuat</label>
                        <p class="text-gray-900">{{ $information->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div>
                    <div class="mb-3">
                        <label class="block text-sm font-bold text-gray-500 mb-1">Tanggal Diperbarui</label>
                        <p class="text-gray-900">{{ $information->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2 mt-6 border-t pt-4">
                <a href="{{ route('admin.information.edit', $information->id) }}" 
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                    <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                </a>
                
                <button type="button" 
                        onclick="openDeleteModal('delete-form-info-{{ $information->id }}')" 
                        class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                </button>
                
                <form id="delete-form-info-{{ $information->id }}" 
                    action="{{ route('admin.information.destroy', $information->id) }}" 
                    method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>


    <div class="bg-white shadow-md rounded-lg">
        <div class="p-4 bg-gray-100 border-b rounded-t-lg flex justify-between items-center">
            <h5 class="text-lg font-semibold text-gray-800">Galeri Gambar</h5>
            <button type="button" 
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded-lg text-sm transition duration-150"
                    onclick="openModal('addGalleryModal')">
                <i data-feather="plus" class="w-4 h-4 mr-1"></i> Tambah Gambar
            </button>
        </div>
        <div class="p-6">
            @if ($information->imageContents->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($information->imageContents as $image)
                        <div>
                            <div class="text-center group">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gambar Galeri"
                                    class="w-full h-32 object-cover rounded-lg mb-2 shadow-sm border group-hover:shadow-md transition duration-150 cursor-pointer"
                                    onclick="openViewImageModal('{{ asset('storage/' . $image->image_path) }}')">
                                <div class="flex justify-center space-x-1">
                                    <button class="inline-flex items-center bg-indigo-100 text-indigo-800 hover:bg-indigo-200 py-1 px-2 rounded-lg text-xs transition duration-150"
                                        onclick="openViewImageModal('{{ asset('storage/' . $image->image_path) }}')"
                                        title="Lihat Detail">
                                        <i data-feather="eye" class="w-3 h-3 mr-1"></i> Lihat
                                    </button>
                                    
                                    <button type="button" 
                                            onclick="openDeleteModal('delete-form-gallery-{{ $image->id }}')"
                                            class="inline-flex items-center bg-red-100 text-red-800 hover:bg-red-200 py-1 px-2 rounded-lg text-xs transition duration-150"
                                            title="Hapus Gambar">
                                        <i data-feather="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                                    </button>
                                    
                                    <form id="delete-form-gallery-{{ $image->id }}"
                                        action="{{ route('admin.information.gallery.destroy', $image->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed">
                    <i data-feather="image" class="text-gray-400 mx-auto mb-3 w-12 h-12"></i>
                    <p class="text-gray-500">Belum ada gambar galeri.</p>
                </div>
            @endif
        </div>
    </div>


    <div id="addGalleryModal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative w-full max-w-3xl max-h-full mx-auto p-4">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h5 class="text-xl font-semibold text-gray-900">Tambah Gambar Galeri</h5>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        onclick="closeModal('addGalleryModal')" aria-label="Tutup">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.information.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="information_id" value="{{ $information->id }}">
                        <div>
                            <label for="gallery_images" class="block text-sm font-bold text-gray-700 mb-1">Pilih Gambar Galeri</label>
                            <input type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                id="gallery_images" name="gallery_images[]" multiple required accept="image/*">
                            <small class="text-gray-500">Pilih satu atau beberapa gambar (JPEG, PNG, JPG, GIF, maksimal 2MB)</small>
                        </div>
                        <div class="flex justify-end space-x-3 pt-2">
                            <button type="button" class="py-2 px-4 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition" 
                                    onclick="closeModal('addGalleryModal')">Batal</button>
                            <button type="submit" class="py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="viewImageModal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75 backdrop-blur-sm">
        <div class="relative w-full max-w-5xl max-h-full mx-auto p-4">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h5 class="text-xl font-semibold text-gray-900">Detail Gambar</h5>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        onclick="closeModal('viewImageModal')" aria-label="Tutup">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div class="p-6 text-center">
                    <img id="viewImageSrc" src="" alt="Detail Gambar" class="max-w-full h-auto rounded-lg mx-auto">
                </div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative w-full max-w-sm mx-auto p-4">
            <div class="relative bg-white rounded-lg shadow-xl p-6">
                <div class="flex flex-col items-center">
                    <i data-feather="alert-triangle" class="w-12 h-12 text-red-600 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Item?</h3>
                    <p class="text-sm text-gray-600 text-center mb-6">
                        Anda yakin ingin menghapus item ini? Aksi ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-between space-x-4">
                    <button onclick="closeModal('deleteConfirmationModal')" 
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
    </div>




    <script>
        // --- FUNGSI UTAMA MODAL (REUSE) ---

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Menggunakan 'flex' untuk menampilkan
                document.body.classList.add('overflow-hidden'); // Mencegah scrolling body
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
        
        // --- LOGIKA VIEW GAMBAR (MENGGANTI BOOTSTRAP) ---
        
        function openViewImageModal(imageSrc) {
            document.getElementById('viewImageSrc').src = imageSrc;
            openModal('viewImageModal');
        }

        // --- LOGIKA DELETE (MENGGANTI confirm() dan memastikan form disubmit) ---
        
        // Variabel global untuk menyimpan ID form yang akan dihapus
        let currentDeleteFormId = null; 

        function openDeleteModal(formId) {
            currentDeleteFormId = formId;
            const confirmBtn = document.getElementById('confirm-delete-btn');
            
            // Menghubungkan tombol konfirmasi di modal dengan form yang benar
            confirmBtn.onclick = function() {
                if (currentDeleteFormId) {
                    document.getElementById(currentDeleteFormId).submit();
                    closeModal('deleteConfirmationModal'); // Tutup modal sebelum submit (opsional)
                }
            };

            openModal('deleteConfirmationModal');
        }

        // --- LOGIKA PENUTUPAN MODAL DENGAN KLIK DI LUAR DAN ESC ---
        
        document.addEventListener('DOMContentLoaded', () => {
            const modalIds = ['addGalleryModal', 'viewImageModal', 'deleteConfirmationModal'];
            
            modalIds.forEach(id => {
                const modal = document.getElementById(id);
                if (modal) {
                    // Tutup saat klik di luar (overlay)
                    modal.addEventListener('click', (event) => {
                        if (event.target === modal) {
                            closeModal(id);
                        }
                    });
                }
            });

            // Tutup saat menekan tombol ESC
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    modalIds.forEach(id => {
                        const modal = document.getElementById(id);
                        if (modal && modal.classList.contains('flex')) {
                            closeModal(id);
                        }
                    });
                }
            });
        });

    </script>
@endsection
