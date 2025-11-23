@extends('layouts.guest')

@section('content')

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
                    <select name="category"
                        onchange="this.form.submit()"
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
                    <input type="text" name="search" placeholder="Cari informasi umum"
                        value="{{ request('search') }}"
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
        <div class="mx-12 grid sm:grid-cols-2 md:grid-cols-3 gap-8 mt-4">

            @forelse ($informations as $information)
                <div data-aos="zoom-in" data-aos-duration="1000" class="bg-white text-gray-800 rounded-xl overflow-hidden shadow-lg flex flex-col">

                    {{-- Gambar cover --}}
                    @if ($information->cover_image)
                        <img src="{{ asset('storage/' . $information->cover_image) }}"
                            class="w-full h-48 object-cover" alt="{{ $information->title }}">
                    @elseif ($information->imageContents->first())
                        <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                            class="w-full h-48 object-cover" alt="{{ $information->title }}">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <i data-feather="image" class="w-12 h-12 text-gray-500"></i>
                        </div>
                    @endif

                    <div class="p-4 flex flex-col flex-grow">
                        <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-full self-start mb-2">
                            {{ $information->category->name ?? 'Umum' }}
                        </span>

                        <h3 class="font-semibold text-sm mb-2">
                            {{ Str::limit($information->title, 60) }}
                        </h3>

                        <p class="text-xs text-gray-600 flex-grow">
                            {{ Str::limit(strip_tags($information->content), 100) }}
                        </p>

                        <div class="flex justify-between items-center mt-3">
                            <span class="text-xs text-gray-500">
                                {{ $information->created_at->diffForHumans() }}
                            </span>

                            <a href="{{ route('information.show', $information->id) }}"
                                class="text-purple-600 text-xs font-medium hover:underline relative z-99">
                                Baca Selengkapnya
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
                {{ $informations->links('pagination::tailwind') }}
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
