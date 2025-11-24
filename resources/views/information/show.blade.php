@extends('layouts.guest')

@section('content')

    <section id="informasi" class="bg-gray-100 py-16 pb-28">

        <div class="mx-12">

            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-600 mb-4">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('index') }}" class="hover:underline">Beranda</a></li>
                    <li>/</li>
                    <li><a href="{{ route('information.index') }}" class="hover:underline">Informasi Umum</a></li>
                    <li>/</li>
                    <li class="text-gray-800 font-medium">{{ Str::limit($information->title, 50) }}</li>
                </ol>
            </nav>

            <!-- HERO IMAGE + TITLE -->
            <div class="relative w-full mb-8">
                @if ($information->cover_image)
                    <img src="{{ asset('storage/' . $information->cover_image) }}"
                        class="w-full h-64 sm:h-80 md:h-96 lg:h-[28rem] object-cover rounded-xl shadow-lg">
                @elseif ($information->imageContents->first())
                    <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                        class="w-full h-64 sm:h-80 md:h-96 lg:h-[28rem] object-cover rounded-xl shadow-lg">
                @else
                    <div
                        class="w-full h-64 sm:h-80 md:h-96 lg:h-[28rem] bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center shadow-lg">
                        <div class="text-center">
                            <i data-feather="image" class="w-20 h-20 text-gray-400 mx-auto mb-4"></i>
                            <p class="text-gray-500 font-medium">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif

                <!-- Title Overlay -->
                <div
                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent rounded-b-xl p-6">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">
                        {!! nl2br(e($information->title)) !!}
                    </h1>
                </div>
            </div>

            <!-- META INFO -->
            <div class="bg-white rounded-lg p-4 shadow-sm mb-8">
                <div class="flex flex-wrap items-center gap-4 text-gray-600 text-sm">
                    <div class="flex items-center">
                        <i data-feather="calendar" class="w-4 h-4 mr-2 text-gray-500"></i>
                        <span>{{ $information->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="flex items-center">
                        <i data-feather="clock" class="w-4 h-4 mr-2 text-gray-500"></i>
                        <span>{{ $information->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="ml-auto">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <i data-feather="tag" class="w-3 h-3 mr-1"></i>
                            {{ $information->category->name ?? 'Umum' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="p-6 sm:p-8">
                    <div class="content-area text-gray-800 leading-relaxed">
                        <div class="space-y-6">
                            {!! make_links_clickable(nl2br(e($information->content))) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- IMAGE GALLERY -->
            @if ($information->imageContents->count() > 0)
                <div class="mt-12 bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <i data-feather="image" class="w-5 h-5 mr-2 text-gray-500"></i>
                        Galeri Foto
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($information->imageContents as $img)
                            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer aspect-video"
                                onclick="openImageModal('{{ asset('storage/' . $img->image_path) }}')">
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    alt="Galeri foto {{ $loop->iteration }}">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center pointer-events-none">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <i data-feather="zoom-in" class="w-8 h-8 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- BUTTON KEMBALI -->
            <div class="mb-8">
                <a href="{{ route('information.index') }}"
                    class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                    Kembali ke Daftar Informasi
                </a>
            </div>

            <!-- RELATED INFORMATION -->
            @if ($relatedInformations->count() > 0)
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <i data-feather="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                        Informasi Terkait
                    </h3>

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedInformations as $related)
                            <a href="{{ route('information.show', encrypt($related->id)) }}" class="group block">
                                <article
                                    class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200">

                                    {{-- Image --}}
                                    <div class="aspect-[16/9] overflow-hidden relative">
                                        @if ($related->cover_image)
                                            <img src="{{ asset('storage/' . $related->cover_image) }}"
                                                class="w-full h-full object-cover" alt="{{ $related->title }}">
                                        @elseif ($related->imageContents->first())
                                            <img src="{{ asset('storage/' . $related->imageContents->first()->image_path) }}"
                                                class="w-full h-full object-cover" alt="{{ $related->title }}">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                                                <i data-feather="file-text" class="w-12 h-12 text-purple-400"></i>
                                            </div>
                                        @endif

                                        {{-- Category Badge --}}
                                        <div class="absolute top-3 left-3">
                                            <span
                                                class="bg-white/90 backdrop-blur-sm text-purple-700 text-xs px-3 py-1 rounded-full font-semibold shadow-lg">
                                                {{ $related->category->name ?? 'Umum' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-5">
                                        <h4
                                            class="font-bold text-lg mb-3 line-clamp-2 leading-tight text-gray-900 group-hover:text-purple-600 transition-colors">
                                            {{ Str::limit($related->title, 70) }}
                                        </h4>

                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                            {!! Str::words(make_links_clickable(strip_tags($related->content)), 15, '...') !!}
                                        </p>

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                                <span>{{ $related->created_at->diffForHumans() }}</span>
                                            </div>

                                            <div class="text-purple-600 group-hover:text-purple-700 transition-colors">
                                                <span class="text-sm font-semibold mr-2">Baca Selengkapnya</span>
                                                <i data-feather="arrow-right" class="w-4 h-4 inline"></i>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- MODAL PREVIEW FOTO -->
        <div id="imageModal"
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4 hidden backdrop-blur-sm">
            <div class="bg-white rounded-xl overflow-hidden max-w-4xl w-full relative shadow-2xl">
                <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                    <h5 class="text-lg font-semibold text-gray-900">Preview Gambar</h5>
                    <button onclick="closeImageModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition-colors">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div class="p-4">
                    <img id="modalImage" src="" class="w-full object-contain max-h-[70vh] rounded-lg">
                </div>
            </div>
        </div>

    </section>



    @include('components.landing-footer')

    <style>
        .content-area {
            font-size: 1.125rem;
            line-height: 1.75;
        }

        .content-area p {
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .content-area p:last-child {
            margin-bottom: 0;
        }

        .content-area br {
            margin-bottom: 0.5rem;
        }

        .content-area a {
            color: #7c3aed;
            text-decoration: underline;
            font-weight: 500;
        }

        .content-area a:hover {
            color: #6d28d9;
        }

        /* Improve readability for long content */
        .content-area strong,
        .content-area b {
            font-weight: 600;
            color: #1f2937;
        }

        .content-area em,
        .content-area i {
            font-style: italic;
            color: #4b5563;
        }

        /* Add some spacing for better structure */
        .content-area ul,
        .content-area ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .content-area li {
            margin-bottom: 0.5rem;
        }

        .content-area blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6b7280;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });

        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
        }
    </script>

@endsection
