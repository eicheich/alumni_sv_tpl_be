<!-- NAVBAR -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center font-semibold text-lg">
                <img src="{{ asset('resources/images/logo-TPL.png') }}" class="h-10 mr-2" alt="Logo TRPL SV IPB">
                Web Alumni TPL
            </div>

            <!-- Mobile Button -->
            <div class="flex items-center md:hidden">
                <button id="mobileMenuButton" class="text-gray-600 hover:text-purple-600 focus:outline-none">
                    <svg id="hamburgerIcon" class="h-6 w-6 block" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg id="closeIcon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
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

                <a href="{{ route('faq.index') }}"
                    class="{{ request()->routeIs('faq.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">FAQ</a>
            </div>

            <!-- Desktop Right Side -->
            <div class="hidden md:flex items-center space-x-3">

                @if (!Auth::guard('alumni')->check() && !Auth::guard('admin')->check())
                    <!-- Guest (not logged-in at all) -->
                    <a href="{{ route('login.view') }}">
                        <button class="bg-purple-600 text-white px-5 py-2 rounded-md text-sm hover:bg-purple-700">
                            Masuk
                        </button>
                    </a>
                    <a href="{{ route('alumni.validate-data.view') }}">
                        <button class="bg-purple-600 text-white px-5 py-2 rounded-md text-sm hover:bg-purple-700">
                            Daftar
                        </button>
                    </a>
                @endif

                @auth('alumni')
                    <!-- Alumni -->
                    <a href="{{ route('alumni.profile') }}" class="flex items-center hover:opacity-80">
                        @if (auth('alumni')->user()->photo_profile)
                            <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                                class="w-9 h-9 rounded-full object-cover border-2 border-purple-200">
                        @else
                            <div class="w-9 h-9 rounded-full bg-purple-200 flex items-center justify-center">
                                <i data-feather="user" class="w-5 h-5 text-purple-600"></i>
                            </div>
                        @endif
                    </a>
                @endauth

                @auth('admin')
                    <!-- Admin -->
                    <a href="{{ route('admin.dashboard.index') }}">
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg">
                            Admin Panel
                        </button>
                    </a>
                @endauth

            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="md:hidden hidden flex-col px-4 pb-4 space-y-3 text-sm font-medium">

        <a href="{{ route('index') }}"
            class="block {{ request()->routeIs('index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Beranda</a>

        <a href="{{ route('about.index') }}"
            class="block {{ request()->routeIs('about.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Tentang</a>

        <a href="{{ route('information.index') }}"
            class="block {{ request()->routeIs('information.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Informasi
            Umum</a>

        <a href="{{ route('faq.index') }}"
            class="block {{ request()->routeIs('faq.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">FAQ</a>

        <!-- MOBILE GUEST -->
        @if (!Auth::guard('alumni')->check() && !Auth::guard('admin')->check())
            <div class="flex gap-2 pt-2">
                <a href="{{ route('login.view') }}" class="flex-1">
                    <button class="w-full bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">
                        Masuk
                    </button>
                </a>
                <a href="{{ route('alumni.validate-data.view') }}" class="flex-1">
                    <button class="w-full bg-purple-400 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-500">
                        Daftar
                    </button>
                </a>
            </div>
        @endif

        <!-- MOBILE ALUMNI -->
        @auth('alumni')
            <a href="{{ route('alumni.profile') }}" class="flex items-center space-x-3 pt-2 border-t">
                @if (auth('alumni')->user()->photo_profile)
                    <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                        class="w-10 h-10 rounded-full object-cover border-2 border-purple-200">
                @else
                    <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                        <i data-feather="user" class="w-5 h-5 text-purple-600"></i>
                    </div>
                @endif
                <span class="font-medium text-gray-700">{{ auth('alumni')->user()?->name ?? 'User' }}</span>
            </a>
        @endauth

        <!-- MOBILE ADMIN -->
        @auth('admin')
            <a href="{{ route('admin.dashboard.index') }}"
                class="block bg-purple-600 text-white text-center py-2 rounded-md mt-2">
                Admin Panel
            </a>
        @endauth
    </div>
</nav>


<!-- MOBILE TOGGLE SCRIPT -->
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
