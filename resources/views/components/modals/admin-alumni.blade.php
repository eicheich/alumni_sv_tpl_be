@php
    $modalAction = Route::has('admin.alumni.store') ? route('admin.alumni.store') : '#';
@endphp



<!-- MODAL -->
<div id="addAlumniModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition duration-200">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
        <button data-close-modal class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            ✕
        </button>

        <h2 class="text-xl font-semibold mb-4 border-b">Tambah Alumni</h2>
        <!-- isi form -->


        <!-- FORM -->
        <form action="{{ $modalAction }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <!-- FOTO -->
            <div class="flex flex-col col-span-2 justify-center items-center mb-4">
                <input type="file" id="profile-upload" name="photo_profile"
                    class="hidden @error('photo_profile') border border-red-500 @enderror" accept="image/*"
                    onchange="document.getElementById('profile-image-preview').src = window.URL.createObjectURL(this.files[0])">

                <label for="profile-upload"
                    class="relative w-24 h-24 rounded-full overflow-hidden
                            border-4 border-gray-300 hover:border-indigo-500
                            cursor-pointer bg-gray-100 shadow-md transition duration-300 group">

                    <img id="profile-image-preview" src="https://via.placeholder.com/150/f0f0f0?text=Pilih+Foto"
                        alt="Pratinjau Foto Profil" class="w-full h-full object-cover">

                    <div
                        class="absolute inset-0 bg-black bg-opacity-40
                                flex items-center justify-center opacity-0 group-hover:opacity-100
                                transition duration-300">
                        <i data-feather="camera" class="w-8 h-8 text-white"></i>
                    </div>
                </label>

                <label for="profile-upload"
                    class="mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium cursor-pointer">
                    Ubah Foto Profil
                </label>
                @error('photo_profile')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror

            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Nama</label>
                <input id="name" name="name" type="text" placeholder="Masukkan nama"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('name') border border-red-500 @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">NIM</label>
                <input id="nim" name="nim" type="text" placeholder="cth. J0403xxxxxx"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('nim') border border-red-500 @enderror"
                    value="{{ old('nim') }}">
                @error('nim')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Angkatan</label>
                <input id="angkatan" name="angkatan" type="text" placeholder="cth. 61"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('angkatan') border border-red-500 @enderror"
                    value="{{ old('angkatan') }}">
                @error('angkatan')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Tahun Lulus</label>
                <input id="graduation_year" name="graduation_year" type="number" placeholder="cth. 2024"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('graduation_year') border border-red-500 @enderror"
                    value="{{ old('graduation_year') }}">
                @error('graduation_year')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" placeholder="cth. budiono67@gmail.com"
                    class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('email') border border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Program Studi</label>
                @if (isset($majors) &&
                        (is_array($majors) ||
                            $majors instanceof \Illuminate\Contracts\Support\Arrayable ||
                            (is_object($majors) && count((array) $majors) > 0)))
                    <select id="major" name="major_id"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('major') border border-red-500 @enderror"
                        value="{{ old('major') }}">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($majors as $m)
                            @php
                                $val = is_object($m) ? $m->id ?? $m : $m;
                                $label = is_object($m) ? $m->name ?? $m : $m;
                            @endphp
                            <option value="{{ $val }}"
                                {{ (string) old('major') === (string) $val || (string) old('major') === (string) $label ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                @else
                    <input
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('major') border border-red-500 @enderror"
                        value="{{ old('major') }}">
                @endif
                @error('major')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="col-span-2 grid grid-cols-2 gap-4 mt-4">
                <button data-close-modal type="button"
                    class="w-full py-2 bg-gray-200 text-black rounded-lg font-medium hover:opacity-90 transition">Batal</button>
                <button type="submit"
                    class="w-full py-2 bg-purple-600 text-white rounded-lg font-medium hover:opacity-90 transition">Simpan</button>
            </div>
        </form>

    </div>
</div>


















<!-- Standard Bootstrap modal (no blade component) -->
{{-- <div class="modal fade" id="addAlumniModal" tabindex="-1" aria-labelledby="addAlumniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlumniModalLabel">Add Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $modalAction }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    form fields
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="major" class="form-label">Program Studi</label>
                            @if (isset($major) && (is_array($major) || $major instanceof \Illuminate\Contracts\Support\Arrayable || (is_object($major) && count((array) $major) > 0)))
                                <select id="major" name="major_id"
                                    class="form-control @error('major') is-invalid @enderror">
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($major as $m)
                                        @php
                                            $val = is_object($m) ? $m->id ?? $m : $m;
                                            $label = is_object($m) ? $m->name ?? $m : $m;
                                        @endphp
                                        <option value="{{ $val }}"
                                            {{ (string) old('major') === (string) $val || (string) old('major') === (string) $label ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="major" name="major" type="text"
                                    class="form-control @error('major') is-invalid @enderror"
                                    value="{{ old('major') }}">
                            @endif
                            @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nim" class="form-label">NIM</label>
                            <input id="nim" name="nim" type="text"
                                class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="photo" class="form-label">Photo</label>
                            <input id="photo" name="photo_profile" type="file"
                                class="form-control @error('photo_profile') is-invalid @enderror">
                            @error('photo_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    end fields


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Alumni</button>
            </div>
            </form>
        </div>
    </div>
</div> --}}
