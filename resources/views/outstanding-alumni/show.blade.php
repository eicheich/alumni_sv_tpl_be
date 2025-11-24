@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Profile Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-4xl mx-auto px-4 py-8">
                <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                    <!-- Profile Photo -->
                    <div class="relative">
                        @if ($outstandingAlumni->alumni->user->photo_profile)
                            <img src="{{ asset('storage/' . $outstandingAlumni->alumni->user->photo_profile) }}"
                                alt="{{ $outstandingAlumni->alumni->user->name ?? 'Alumni' }}"
                                class="w-24 h-24 md:w-32 md:h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div
                                class="w-24 h-24 md:w-32 md:h-32 bg-gray-200 rounded-full border-4 border-gray-200 flex items-center justify-center">
                                <i data-feather="user" class="w-12 h-12 md:w-16 md:h-16 text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Info -->
                    <div class="text-center md:text-left flex-1">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                            {{ $outstandingAlumni->alumni->user->name ?? 'Nama Alumni' }}
                        </h1>
                        <p class="text-gray-600 mb-3">
                            {{ $outstandingAlumni->alumni->major->name ?? 'Program Studi' }}
                        </p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            {{ $outstandingAlumni->award_title ?? 'Alumni Berprestasi' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Achievement Description -->
            @if ($outstandingAlumni->description)
                <div class="bg-white rounded-lg p-6 mb-8 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Tentang Penghargaan</h2>
                    <div class="text-gray-700 leading-relaxed">{!! make_links_clickable(nl2br(e($outstandingAlumni->description))) !!}</div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Career History -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i data-feather="briefcase" class="w-5 h-5 mr-2 text-gray-500"></i>
                        Riwayat Karir
                    </h2>

                    @if ($outstandingAlumni->alumni->careers->count() > 0)
                        <div class="space-y-4">
                            @foreach ($outstandingAlumni->alumni->careers as $career)
                                <div class="pb-4 border-b border-gray-100 last:border-b-0 last:pb-0">
                                    <div class="mb-2">
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Posisi</span>
                                        <h3 class="font-medium text-gray-900">{{ $career->position ?? 'Posisi' }}</h3>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Perusahaan</span>
                                        <p class="text-gray-600 text-sm">{{ $career->company_name ?? 'Perusahaan' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Periode</span>
                                        <p class="text-gray-500 text-xs">
                                            {{ \Carbon\Carbon::parse($career->start_date)->format('M Y') }}
                                            @if ($career->end_date)
                                                - {{ \Carbon\Carbon::parse($career->end_date)->format('M Y') }}
                                            @else
                                                - Sekarang
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada data karir</p>
                    @endif
                </div>

                <!-- Education History -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i data-feather="book" class="w-5 h-5 mr-2 text-gray-500"></i>
                        Riwayat Pendidikan
                    </h2>

                    @if ($outstandingAlumni->alumni->educationalBackgrounds->count() > 0)
                        <div class="space-y-4">
                            @foreach ($outstandingAlumni->alumni->educationalBackgrounds as $education)
                                <div class="pb-4 border-b border-gray-100 last:border-b-0 last:pb-0">
                                    <div class="mb-2">
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Jurusan</span>
                                        <h3 class="font-medium text-gray-900">{{ $education->major ?? 'Jurusan' }}</h3>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Institusi</span>
                                        <p class="text-gray-600 text-sm">{{ $education->institution_name ?? 'Institusi' }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Tahun</span>
                                        <p class="text-gray-500 text-xs">
                                            {{ $education->entry_year ?? '-' }} - {{ $education->graduation_year ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada data pendidikan</p>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6 relative z-99">
                <a href="{{ route('index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-400 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                    ← Kembali ke beranda
                </a>
            </div>
        </div>

        @include('components.landing-footer')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
            });
        </script>
    @endsection
