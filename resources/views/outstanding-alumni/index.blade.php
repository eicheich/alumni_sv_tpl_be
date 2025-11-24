@extends('layouts.guest')

@section('title', 'Alumni TPL - Alumni Berprestasi')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-32"
        style="background-image: url('{{ asset('resources/images/hero.png') }}');">
        <div class="absolute inset-0 bg-purple-900 bg-opacity-70"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">Alumni Berprestasi</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto text-white">
                Prestasi dan pencapaian luar biasa dari alumni terbaik kami yang menginspirasi generasi mendatang
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex flex-wrap justify-center gap-8">

                <!-- Card-->
                @forelse($outstandingAlumni as $alumni)
                    <div class="bg-white rounded-2xl overflow-hidden w-full sm:w-80 border border-gray-100">
                        <div class="h-32 overflow-hidden">
                            <img src="{{ asset('resources/images/wave.svg') }}" class="h-40 w-full object-cover"
                                alt="">
                        </div>
                        <div class="-mt-24 flex justify-center">
                            @if ($alumni->alumni->user->photo_profile)
                                <img src="{{ asset('storage/' . $alumni->alumni->user->photo_profile) }}" alt="Alumni"
                                    class="rounded-full border-4 border-white w-24 h-24 object-cover">
                            @else
                                <div
                                    class="w-24 h-24 bg-gray-400 rounded-full flex items-center justify-center border-4 border-white">
                                    <i data-feather="user" class="w-12 h-12 text-white/50"></i>
                                </div>
                            @endif
                        </div>
                        <div class="px-6 pb-6 pt-4 text-center">
                            <p class="text-sm text-purple-600 font-semibold mb-1">{{ $alumni->award_title }}</p>
                            <h3 class="text-xl font-bold mt-2 mb-1">{{ $alumni->alumni->user->name ?? 'Nama Alumni' }}</h3>
                            <p class="text-gray-600 mb-2">{{ $alumni->alumni->major->name ?? 'Program Studi' }}</p>
                            <p class="text-sm font-medium text-gray-800 mb-4"><i
                                    class="fa-solid me-1 fa-briefcase text-purple-600"></i>
                                @if ($alumni->alumni->educationalBackgrounds->isNotEmpty())
                                    Tahun Lulus:
                                    {{ $alumni->alumni->educationalBackgrounds->first()->graduation_year ?? '-' }}
                                @else
                                    -
                                @endif
                            </p>
                            <a href="{{ route('outstanding-alumni.show', encrypt($alumni->id)) }}"
                                class="inline-block bg-purple-600 text-white px-6 py-3 rounded-xl text-sm font-semibold">
                                Lihat Profil Lengkap
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-16">
                        <div class="bg-white rounded-2xl p-12 max-w-lg mx-auto shadow-lg">
                            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-feather="award" class="w-10 h-10 text-purple-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-gray-900">Belum Ada Alumni Berprestasi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Profil alumni berprestasi akan segera ditampilkan di halaman ini
                            </p>
                        </div>
                    </div>
                @endforelse

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
