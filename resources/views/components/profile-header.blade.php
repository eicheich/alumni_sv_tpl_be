<!-- NAVBAR -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center font-semibold text-lg">
                <img src="{{ Vite::asset('resources/images/logo-TPL.png') }}" class="h-10 mr-2" alt="Logo TRPL SV IPB">
                Web Alumni TRPL SV IPB
            </div> <!-- Mobile Button -->
            <div class="flex items-center md:hidden">
                <button id="mobileMenuButton" class="text-gray-600 hover:text-purple-600 focus:outline-none">
                    <!-- Icon -->
                    <svg id="hamburgerIcon" class="h-6 w-6 block" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="closeIcon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center gap-8 text-sm font-medium">
                <a href="{{ route('index') }}"
                    class="{{ request()->routeIs('index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Beranda</a>
                <a href="{{ route('about.index') }}"
                    class="{{ request()->routeIs('about.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Tentang</a>
                <a href="{{ route('information.index') }}"
                    class="{{ request()->routeIs('information.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Informasi
                    Umum</a>
                <a href="#faq" class="hover:text-purple-600">FAQ</a>
            </div>

            <!-- Desktop Profile -->
            <div class="hidden md:flex items-center">
                <a href="{{ route('alumni.profile') }}" class="flex items-center hover:opacity-80 transition">
                    @if (auth('alumni')->user()->photo_profile)
                        <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                            alt="{{ auth('alumni')->user()->name }}"
                            class="w-9 h-9 rounded-full object-cover border-2 border-purple-200">
                    @else
                        <div class="w-9 h-9 rounded-full bg-purple-200 flex items-center justify-center">
                            <i data-feather="user" class="w-5 h-5 text-purple-600"></i>
                        </div>
                    @endif
                </a>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden flex-col px-4 pb-4 space-y-3 text-sm font-medium">
        <a href="{{ route('index') }}"
            class="block {{ request()->routeIs('index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">
            Beranda
        </a>

        <a href="{{ route('about.index') }}"
            class="block {{ request()->routeIs('about.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">
            Tentang
        </a>

        <a href="{{ route('information.index') }}"
            class="block {{ request()->routeIs('information.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">
            Informasi Umum
        </a>

        <a href="#faq" class="block hover:text-purple-600">
            FAQ
        </a>

        <!-- Mobile Profile Link -->
        <a href="{{ route('alumni.profile') }}" class="flex items-center space-x-3 pt-2 border-t">
            @if (auth('alumni')->user()->photo_profile)
                <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                    class="w-10 h-10 rounded-full object-cover border-2 border-purple-200">
            @else
                <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                    <i data-feather="user" class="w-5 h-5 text-purple-600"></i>
                </div>
            @endif
            <span class="font-medium text-gray-700">{{ auth('alumni')->user()->name }}</span>
        </a>
    </div>
</nav>

<!-- TOGGLE SCRIPT -->
<script>
    document.getElementById("mobileMenuButton").addEventListener("click", () => {
        const menu = document.getElementById("mobileMenu");
        const hamburger = document.getElementById("hamburgerIcon");
        const closeIcon = document.getElementById("closeIcon");

        const isHidden = menu.classList.contains("hidden");

        if (isHidden) {
            menu.classList.remove("hidden");
            hamburger.classList.add("hidden");
            closeIcon.classList.remove("hidden");
        } else {
            menu.classList.add("hidden");
            hamburger.classList.remove("hidden");
            closeIcon.classList.add("hidden");
        }
    });
</script>
