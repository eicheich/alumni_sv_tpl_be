@extends('layouts.main')

@section('title', 'Edit Informasi')

@section('content')


    <!-- Modal Tambah Informasi -->

    <div class="mb-4">
        <a href="{{ route('admin.information.index') }}"
            class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150">

            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>

            Kembali
        </a>
    </div>


    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h2 class="text-xl font-semibold mb-4 border-b">Formulir Edit Informasi</h2>


        <form action="{{ route('admin.information.update', encrypt($information->id)) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            {{-- Pastikan Anda menggunakan method PUT untuk update --}}

            @if ($information->cover_image)
                <div class="border p-4 rounded-lg bg-gray-50">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Cover Saat Ini</label>
                    <div>
                        <img src="{{ asset('storage/' . $information->cover_image) }}" alt="{{ $information->title }}"
                            class="max-h-52 w-auto border border-gray-300 rounded-lg shadow-sm object-cover">
                    </div>
                </div>
            @endif

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Cover Baru
                    (Opsional)</label>
                <input type="file" id="photo" name="photo"
                    class="block w-full text-sm text-gray-900 border @error('photo') border-red-500 @else border-gray-300 @enderror rounded-lg cursor-pointer bg-gray-50 p-2.5">

                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto cover.</p>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                    id="title" name="title" value="{{ old('title', $information->title) }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="information_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('information_category_id') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                    id="information_category_id" name="information_category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($informationCategories ?? [] as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('information_category_id', $information->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('information_category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                <textarea
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('content') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                    id="content" name="content" rows="5" required>{{ old('content', $information->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="py-3">
                <label for="is_archive" class="block text-sm font-medium text-gray-700 mb-1">Arsipkan Informasi</label>
                <input type="checkbox" id="is_archive" name="is_archive" value="1"
                    class="form-checkbox h-5 w-5 text-purple-600"
                    {{ old('is_archive', $information->is_archive) ? 'checked' : '' }}>
            </div>




            <div class="flex space-x-3 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="bg-blue-600 text-white font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition duration-150 ease-in-out">
                    Update
                </button>
                <a href="{{ route('admin.information.index') }}"
                    class="bg-gray-500 text-white font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 transition duration-150 ease-in-out">
                    Batal
                </a>
            </div>
        </form>
    </div>


@endsection
