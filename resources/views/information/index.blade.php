@extends('layouts.guest')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-32"
        style="background-image: url('{{ asset('resources/images/hero.png') }}');">
        <div class="absolute inset-0 bg-purple-900 bg-opacity-70"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">Informasi Umum</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto text-white">
                Berita, pengumuman, dan informasi penting untuk alumni
            </p>
        </div>
    </section>

    <section id="informasi" class="bg-gray-100 py-16 pb-28">
        <div class="mx-12">

            <!-- Subtitle -->
            <p class="text-sm text-purple-600">Berita, info loker, dan survey SV IPB</p>

            <!-- Header + Search -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                <h1 class="text-xl md:text-2xl font-semibold">
                    Informasi Umum
                </h1>

                <!-- Search Form -->
                <form method="GET" action="{{ route('information.index') }}"
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">

                    <!-- Kategori -->
                    <select name="category" onchange="this.form.submit()"
                        class="w-full sm:w-56 text-sm rounded-lg border border-gray-300 px-3 py-2
                            focus:ring-2 focus:ring-purple-600 bg-white">
                        <option value="">Semua Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Input Search -->
                    <input type="text" name="search" placeholder="Cari informasi umum" value="{{ request('search') }}"
                        class="w-full sm:w-72 rounded-lg border bg-white border-gray-200 px-4 py-2 text-sm
                            focus:ring-2 focus:ring-purple-600">

                    <!-- Button -->
                    <button type="submit"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto
                            hover:bg-purple-700 transition flex justify-center items-center gap-2">
                        <i class="fa fa-search"></i> <span>Cari</span>
                    </button>

                </form>
            </div>



        </div>

        <!-- Cards -->
        <div class="mx-12 grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">

            @forelse ($informations as $information)
                <div
                    class="bg-white text-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">

                    {{-- Gambar cover --}}
                    <div class="aspect-[16/9] overflow-hidden">
                        @if ($information->cover_image)
                            <img src="{{ asset('storage/' . $information->cover_image) }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                alt="{{ $information->title }}">
                        @elseif ($information->imageContents->first())
                            <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                alt="{{ $information->title }}">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i data-feather="image" class="w-16 h-16 text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-full self-start mb-3 font-medium">
                            {{ $information->category->name ?? 'Umum' }}
                        </span>

                        <h3 class="font-bold text-gray-900 text-base mb-3 line-clamp-2 leading-tight">
                            {{ Str::limit($information->title, 60) }}
                        </h3>

                        <div class="text-sm text-gray-600 flex-grow mb-4 leading-relaxed">
                            {!! Str::words(make_links_clickable(strip_tags($information->content)), 20, '...') !!}
                        </div>

                        <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">
                                {{ $information->created_at->diffForHumans() }}
                            </span>

                            <a href="{{ route('information.show', encrypt($information->id)) }}"
                                class="text-purple-600 text-sm font-semibold hover:text-purple-700 hover:underline transition-colors">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    <i data-feather="inbox" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                    Belum ada informasi
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if ($informations->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $informations->links('components.pagination') }}
            </div>
        @endif
    </section>


    @include('components.landing-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
