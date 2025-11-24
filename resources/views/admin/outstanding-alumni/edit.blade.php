@extends('layouts.main')

@section('title', 'Edit Alumni Berprestasi')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.outstanding-alumni.index') }}"
            class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150">

            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>

            Kembali
        </a>
    </div>


    <div class=" flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <h2 class="text-xl font-semibold mb-4 border-b">Edit Alumni Berprestasi</h2>

            <!-- FORM -->
            <form action="{{ route('admin.outstanding-alumni.update', encrypt($outstandingAlumni->id)) }}" method="POST"
                enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama</label>
                    <input id="alumniName" value="{{ $outstandingAlumni->alumni->user->name }}" disabled name="name"
                        type="text" placeholder="Masukkan nama"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Jurusan</label>

                    <input type="text"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none"
                        id="major" value="{{ $outstandingAlumni->alumni->major->name }}" disabled>

                </div>

                <div>
                    <label for="award_title" class="block text-sm text-gray-700 mb-1">Penghargaan / Prestasi <span
                            class="text-danger">*</span></label>
                    <input type="text"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none @error('award_title') is-invalid @enderror"
                        id="award_title" name="award_title"
                        value="{{ old('award_title', $outstandingAlumni->award_title) }}"
                        placeholder="Masukkan penghargaan atau prestasi..." required>
                    @error('award_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class=""></div>


                <!-- Tombol -->
                <a href="{{ route('admin.outstanding-alumni.index') }}"
                    class="w-full py-2 bg-gray-200 text-black rounded-lg font-medium hover:opacity-90 transition text-center">Batal</a>
                <button type="submit"
                    class="w-full py-2 bg-purple-600 text-white rounded-lg font-medium hover:opacity-90 transition">Simpan</button>
            </form>

        </div>
    </div>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
