@extends('layouts.main')

@section('title', 'Informasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Informasi</h6>
    </div>

    <div class="row">
        <!-- Section Kiri: Tabel Informasi (Lebih besar) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Daftar Informasi</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addInformationModal" style="font-size: 0.75rem; padding: 0.125rem 0.25rem;">Tambah
                        Informasi</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($informations ?? [] as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td class="text-truncate" style="max-width: 200px;" title="{{ $info->title }}">
                                        {{ $info->title }}</td>
                                    <td>{{ $info->category->name ?? 'N/A' }}</td>
                                    <td>
                                        @if (Route::has('admin.information.edit'))
                                            <a href="{{ route('admin.information.edit', $info->id) }}"
                                                class="btn btn-outline-primary btn-sm"
                                                style="font-size: 0.75rem; padding: 0.125rem 0.25rem;">Edit</a>
                                        @else
                                            <a href="{{ url('/admin/information/' . $info->id . '/edit') }}"
                                                class="btn btn-outline-primary btn-sm"
                                                style="font-size: 0.75rem; padding: 0.125rem 0.25rem;">Edit</a>
                                        @endif
                                        @if (Route::has('admin.information.destroy'))
                                            <form action="{{ route('admin.information.destroy', $info->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    style="font-size: 0.75rem; padding: 0.125rem 0.25rem;"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">Hapus</button>
                                            </form>
                                        @else
                                            <form action="{{ url('/admin/information/' . $info->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    style="font-size: 0.75rem; padding: 0.125rem 0.25rem;"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data informasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section Kanan: Tabel Category Informasi (Lebih kecil) -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Daftar Kategori Informasi</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal" style="font-size: 0.75rem; padding: 0.125rem 0.25rem;">Tambah
                        Kategori</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($informationCategories ?? [] as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            style="font-size: 0.75rem; padding: 0.125rem 0.25rem;" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal"
                                            onclick="document.getElementById('editCategoryForm').action='{{ route('admin.information.category.update', ':id') }}'.replace(':id', {{ $category->id }}); document.getElementById('edit_name').value='{{ $category->name }}';">Edit</button>
                                        @if (Route::has('admin.information.category.destroy'))
                                            <form action="{{ route('admin.information.category.destroy', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    style="font-size: 0.75rem; padding: 0.125rem 0.25rem;"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                            </form>
                                        @else
                                            <form action="{{ url('/admin/information-category/' . $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    style="font-size: 0.75rem; padding: 0.125rem 0.25rem;"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.information.category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.information.category.update', ':id') }}" id="editCategoryForm"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Informasi -->
    <div class="modal fade" id="addInformationModal" tabindex="-1" aria-labelledby="addInformationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInformationModalLabel">Tambah Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="{{ Route::has('admin.information.store') ? route('admin.information.store') : url('/admin/information') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="information_category_id" class="form-label">Kategori</label>
                            <select class="form-control @error('information_category_id') is-invalid @enderror"
                                id="information_category_id" name="information_category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('information_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('information_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto (Opsional)</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" name="photo">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setEditData(id, name) {
            const form = document.getElementById('editCategoryForm');
            form.action = '{{ route('admin.information.category.update', ':id') }}'.replace(':id', id);
            document.getElementById('edit_name').value = name;
        }
    </script>

@endsection
