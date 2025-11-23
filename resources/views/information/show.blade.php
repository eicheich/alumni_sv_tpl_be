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
            <div class="relative w-full">
                @if ($information->cover_image)
                    <img src="{{ asset('storage/' . $information->cover_image) }}"
                        class="w-full h-56 sm:h-72 md:h-80 lg:h-96 object-cover rounded-lg">
                @elseif ($information->imageContents->first())
                    <img src="{{ asset('storage/' . $information->imageContents->first()->image_path) }}"
                        class="w-full h-56 sm:h-72 md:h-80 lg:h-96 object-cover rounded-lg">
                @else
                    <div class="w-full h-56 sm:h-72 md:h-80 lg:h-96 bg-gray-300 rounded-lg flex items-center justify-center">
                        <i data-feather="image" class="w-16 h-16 text-gray-500"></i>
                    </div>
                @endif

                <h2 class="absolute bottom-0 left-0 w-full text-sm sm:text-base md:text-2xl 
                        font-semibold text-white py-2 px-4 bg-gradient-to-t from-black/60 to-transparent rounded-b-lg">
                    {{ $information->title }}
                </h2>
            </div>

            <!-- META INFO -->
            <div class="mt-4 flex items-center space-x-4 text-gray-600 text-xs sm:text-sm">
                <div class="flex items-center">
                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                    {{ $information->created_at->format('d F Y') }}
                </div>

                <span>•</span>

                <div class="flex items-center">
                    <i data-feather="clock" class="w-4 h-4 mr-1"></i>
                    {{ $information->created_at->diffForHumans() }}
                </div>

                <span>•</span>

                <span class="bg-purple-600 text-white px-3 py-1 text-xs rounded-full">
                    {{ $information->category->name ?? 'Umum' }}
                </span>
            </div>

            <div class="py-6 text-justify leading-relaxed text-gray-700 text-sm sm:text-base lg:text-2xl font-bold">
                {!! nl2br(e($information->title)) !!}
            </div>
            
            <!-- MAIN CONTENT -->
            <div class="py-6 text-justify leading-relaxed text-gray-700 text-sm sm:text-base">
                {!! nl2br(e($information->content)) !!}
            </div>

            <!-- IMAGE GALLERY -->
            @if ($information->imageContents->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-3">Galeri Foto</h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($information->imageContents as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                onclick="openImageModal('{{ asset('storage/' . $img->image_path) }}')"
                                class="rounded-lg shadow cursor-pointer h-36 sm:h-48 w-full object-cover">
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- BUTTON KEMBALI -->
            <div class="mt-6 relative z-99">
                <a href="{{ route('information.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-400 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                    ← Kembali ke Daftar Informasi
                </a>
            </div>

            <!-- RELATED INFORMATION -->
            @if ($relatedInformations->count() > 0)
                <div class="mt-10 bg-white shadow p-5 rounded-xl">
                    <h3 class="font-semibold mb-4">Informasi Terkait</h3>

                    <div class="space-y-4">
                        @foreach ($relatedInformations as $related)
                            <a href="{{ route('information.show', $related->id) }}"
                                class="flex items-start space-x-3 hover:bg-gray-50 p-2 rounded-lg transition">

                                @if ($related->imageContents->first())
                                    <img src="{{ asset('storage/' . $related->imageContents->first()->image_path) }}"
                                        class="w-20 h-14 object-cover rounded">
                                @else
                                    <div class="w-20 h-14 bg-gray-300 rounded flex items-center justify-center">
                                        <i data-feather="image" class="w-5 h-5 text-gray-500"></i>
                                    </div>
                                @endif

                                <div>
                                    <p class="text-sm font-medium">{{ Str::limit($related->title, 60) }}</p>
                                    <p class="text-xs text-gray-500">{{ $related->created_at->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- MODAL PREVIEW FOTO -->
        <div id="imageModal"
            class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg overflow-hidden max-w-4xl w-full relative">
                <button onclick="closeImageModal()"
                    class="absolute top-2 right-2 bg-white rounded-full p-1 shadow">
                    ✕
                </button>
                <img id="modalImage" src="" class="w-full object-contain max-h-[90vh]">
            </div>
        </div>

    </section>



@include('components.landing-footer')
<script>
    function openImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>

@endsection
