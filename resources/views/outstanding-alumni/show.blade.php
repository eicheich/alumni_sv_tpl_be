@extends('layouts.guest')

@section('content')

    <section id="informasi" class="bg-gray-100 pb-28">
        <div class="min-h-screen flex flex-col">

            <!-- Header Gradasi -->
            <div class="bg-indigo-500 h-32 flex flex-col items-center justify-end pb-6 relative">

                <!-- Foto Profil -->
                @if ($outstandingAlumni->alumni->user->photo_profile)
                    <img src="{{ asset('storage/' . $outstandingAlumni->alumni->user->photo_profile) }}"
                        alt="{{ $outstandingAlumni->alumni->user->name }}"
                        class="w-28 h-28 object-cover rounded-lg border-4 border-white shadow-lg absolute -bottom-14">
                @else
                    <div class="w-28 h-28 bg-gray-300 rounded-lg border-4 border-white shadow-lg absolute -bottom-14
                                flex items-center justify-center">
                        <i data-feather="user" class="w-10 h-10 text-white"></i>
                    </div>
                @endif

            </div>

            <!-- Konten Profil -->
            <div class="mt-20 flex flex-col items-center px-4 text-center">
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <h1 class="text-lg font-semibold text-gray-800">
                    {{ $outstandingAlumni->alumni->user->name }}
                </h1>

                <!-- Badge Award -->
                <span class="mt-2 px-4 py-1 rounded-full text-white text-sm
                            bg-purple-600">
                    {{ $outstandingAlumni->award_title }}
                </span>

                <!-- Kontak -->
                <div class="mt-6 text-sm text-gray-600 space-y-1">
                    <p>Email: <span class="font-semibold">{{ $outstandingAlumni->alumni->user->email ?? '-' }}</span></p>
                    <p>Telepon: <span class="font-semibold">{{ $outstandingAlumni->alumni->user->phone ?? '-' }}</span></p>
                    <p>NIM: <span class="font-semibold">{{ $outstandingAlumni->alumni->nim ?? '-' }}</span></p>
                    <p>Prodi: 
                        <span class="font-semibold">
                            {{ $outstandingAlumni->alumni->major->name ?? 'Program Studi' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Bagian Riwayat -->
            <div class="max-w-5xl w-full mx-auto px-6 md:px-40 mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Riwayat Karir -->
                <div>
                    <h2 class="text-gray-500 font-medium mb-4">Riwayat Karir</h2>

                    @if ($outstandingAlumni->alumni->careers->count() > 0)
                        @foreach ($outstandingAlumni->alumni->careers as $career)
                            <div class="mb-6">
                                <p class="text-sm text-gray-500">Nama pekerjaan</p>
                                <p class="font-semibold text-gray-800">{{ $career->position }}</p>

                                <p class="text-sm text-gray-500 mt-1">Nama perusahaan</p>
                                <p class="font-semibold text-gray-800">{{ $career->company_name }}</p>

                                <div class="flex items-center gap-6 mt-2 text-sm">

                                    <p>
                                        <span class="text-gray-500">Tahun masuk:</span>
                                        <span class="font-semibold">
                                            {{ \Carbon\Carbon::parse($career->start_date)->format('Y') }}
                                        </span>
                                    </p>

                                    @if ($career->end_date)
                                        <p>
                                            <span class="text-gray-500">Tahun keluar:</span>
                                            <span class="font-semibold">
                                                {{ \Carbon\Carbon::parse($career->end_date)->format('Y') }}
                                            </span>
                                        </p>
                                    @else
                                        <p>
                                            <span class="text-gray-500">Status:</span>
                                            <span class="font-semibold text-green-600">Aktif</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">Belum ada data karir</p>
                    @endif
                </div>

                <!-- Riwayat Pendidikan -->
                <div>
                    <h2 class="text-gray-500 font-medium mb-4">Riwayat Pendidikan</h2>

                    @if ($outstandingAlumni->alumni->educationalBackgrounds->count() > 0)
                        @foreach ($outstandingAlumni->alumni->educationalBackgrounds as $education)
                            <div class="mb-6">
                                <p class="text-sm text-gray-500">Jenjang</p>
                                <p class="font-semibold text-gray-800">{{ $education->degree }}</p>

                                <p class="text-sm text-gray-500 mt-1">Instansi</p>
                                <p class="font-semibold text-gray-800">{{ $education->institution_name }}</p>

                                <div class="flex items-center gap-6 mt-2 text-sm">
                                    <p>
                                        <span class="text-gray-500">Tahun masuk:</span>
                                        <span class="font-semibold">{{ $education->entry_year }}</span>
                                    </p>
                                    <p>
                                        <span class="text-gray-500">Tahun lulus:</span>
                                        <span class="font-semibold">{{ $education->graduation_year }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">Belum ada data pendidikan</p>
                    @endif
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="text-center mt-10 relative z-99">
                <a href="{{ route('index') }}#alumni-berprestasi"
                    class="px-4 py-2 border border-gray-400 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>
    </section>


    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
