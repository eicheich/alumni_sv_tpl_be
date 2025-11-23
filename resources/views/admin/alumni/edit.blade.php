@extends('layouts.main')

@section('title', 'Edit Alumni')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.alumni.show', $alumni->id) }}" class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150">
            
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            
            Kembali
        </a>
    </div>


    <div class=" flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <h2 class="text-xl font-semibold mb-4 border-b">Edit Alumni</h2>
            
            <!-- FORM -->
            <form action="{{ route('admin.alumni.update', $alumni->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')
                <!-- FOTO -->
                <div class="flex flex-col col-span-2 justify-center items-center mb-4">

                    @if ($alumni->user->photo_profile)
                    
                        <input 
                            type="file" 
                            id="profile-upload" name="photo_profile"
                            class="hidden @error('photo_profile') border border-red-500 @enderror"
                            accept="image/*" 
                            onchange="document.getElementById('profile-image-preview').src = window.URL.createObjectURL(this.files[0])"
                        >
    
                        <label for="profile-upload" 
                            class="relative w-24 h-24 rounded-full overflow-hidden 
                                    border-4 border-gray-300 hover:border-indigo-500 
                                    cursor-pointer bg-gray-100 shadow-md transition duration-300 group">
    
                            <img id="profile-image-preview" 
                                src="{{ asset('storage/' . $alumni->user->photo_profile) }}" 
                                alt=""{{ $alumni->user->name }}" 
                                class="w-full h-full object-cover">
    
                            <div class="absolute inset-0 bg-black bg-opacity-40 
                                        flex items-center justify-center opacity-0 group-hover:opacity-100 
                                        transition duration-300">
                                <i data-feather="camera" class="w-8 h-8 text-white"></i>
                            </div>
                        </label>
    
                        <label for="profile-upload" class="mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium cursor-pointer">
                            Ubah Foto Profil
                        </label>
                        @error('photo_profile')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror



                    @endif
        
                </div>

                <div>
                <label class="block text-sm text-gray-700 mb-1">Nama</label>
                <input id="name" name="name" type="text" placeholder="Masukkan nama"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('name') border border-red-500 @enderror" value="{{ old('name', $alumni->user->name) }}">
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                <label class="block text-sm text-gray-700 mb-1">NIM</label>
                <input id="nim" name="nim" type="text" placeholder="cth. J0403xxxxxx"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('nim') border border-red-500 @enderror" value="{{ old('nim', $alumni->nim) }}">
                    @error('nim')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                <label class="block text-sm text-gray-700 mb-1">Angkatan</label>
                <input id="nim" name="nim" type="text" placeholder="cth. J0403xxxxxx"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('nim') border border-red-500 @enderror" value="{{ old('nim', $alumni->nim) }}">
                    @error('nim')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" placeholder="cth. budiono67@gmail.com"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('email') border border-red-500 @enderror" value="{{ old('email', $alumni->user->email) }}">
                        @error('email')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('birthdate') border border-red-500 @enderror" placeholder="cth. budiono67@gmail.com"
                            id="birthdate" name="birthdate" value="{{ old('birthdate', $alumni->birthdate ?? '') }}">
                        @error('birthdate')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                </div>

                <div>
                <label class="block text-sm text-gray-700 mb-1">Program Studi</label>

                    <select class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('major') border border-red-500 @enderror" id="major_id"
                                name="major_id" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}"
                                {{ old('major_id', $alumni->major_id) == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('major_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                    <a href="{{ route('admin.alumni.show', $alumni->id) }}"  class="w-full py-2 bg-gray-200 text-black rounded-lg font-medium hover:opacity-90 transition text-center">Batal</a>
                    <button type="submit" class="w-full py-2 bg-purple-600 text-white rounded-lg font-medium hover:opacity-90 transition">Simpan</button>
            </form>

        </div>
    </div>










    

    {{-- <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Alumni: {{ $alumni->user->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.alumni.update', $alumni->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $alumni->user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $alumni->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                id="birthdate" name="birthdate" value="{{ old('birthdate', $alumni->birthdate ?? '') }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                name="nim" value="{{ old('nim', $alumni->nim) }}" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="major_id" class="form-label">Jurusan</label>
                            <select class="form-select @error('major_id') is-invalid @enderror" id="major_id"
                                name="major_id" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}"
                                        {{ old('major_id', $alumni->major_id) == $major->id ? 'selected' : '' }}>
                                        {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="photo_profile" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control @error('photo_profile') is-invalid @enderror"
                                id="photo_profile" name="photo_profile" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                            @error('photo_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if ($alumni->user->photo_profile)
                    <div class="mb-3">
                        <label>Foto Profil Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $alumni->user->photo_profile) }}"
                                alt="{{ $alumni->user->name }}" class="img-thumbnail"
                                style="max-height: 150px; object-fit: cover;">
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.alumni.show', $alumni->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
