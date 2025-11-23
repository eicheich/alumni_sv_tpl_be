<nav class="flex items-center justify-between px-12 py-4 bg-white shadow-sm">
    <!-- Logo -->
    <a href="{{ route('index') }}" class="font-semibold text-lg flex items-center">
        <img src="{{ asset('storage/asset/logo.png')}}" class="h-8 mr-2" alt="">
        Web Alumni TPL
    </a>

    <!-- Menu (Desktop) -->
    <ul class="hidden md:flex space-x-6 text-sm font-medium">
        <li><a href="{{route('index')}}" class="{{ request()->routeIs('index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Beranda</a></li>
        <li><a href="{{route('information.index')}}" class="{{ request()->routeIs('information.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Informasi Umum</a></li>
    </ul>

    <!-- Profil + Logout -->
    <div class="hidden md:flex items-center space-x-4">

        <!-- Foto Profil -->
        <a href="{{ route('alumni.profile') }}" class="flex items-center">
            @if (auth('alumni')->user()->photo_profile)
                <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                    alt="{{ auth('alumni')->user()->name }}"
                    class="w-9 h-9 rounded-full object-cover border">
            @else
                <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center">
                    <i data-feather="user" class="w-4 h-4 text-white"></i>
                </div>
            @endif
        </a>

        <!-- Tombol Logout -->
        <form action="{{ route('alumni.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center bg-red-500 text-white px-3 py-2 rounded-md text-sm hover:bg-red-600 transition">
                <i data-feather="log-out" class="w-4 h-4 mr-1"></i>
                Logout
            </button>
        </form>
    </div>

    <!-- Mobile Toggle -->
    <button class="md:hidden" onclick="toggleNav()">
        <i data-feather="menu" class="w-6 h-6"></i>
    </button>
</nav>

<!-- MENU MOBILE -->
<div id="mobileNav" class="hidden md:hidden bg-white px-12 pb-4 shadow-sm">
    <ul class="flex flex-col space-y-3 text-sm font-medium mt-3">
        <li><a href="{{ route('index')}}" class="{{ request()->routeIs('index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Beranda</a></li>
        <li><a href="{{ route('information.index')}}" class="{{ request()->routeIs('information.index') ? 'text-purple-600 font-semibold' : 'hover:text-purple-600' }}">Informasi Umum</a></li>

        <!-- Mobile Profile -->
        <a href="{{ route('alumni.profile') }}" class="flex items-center space-x-3 mt-3">
            @if (auth('alumni')->user()->photo_profile)
                <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                    class="w-10 h-10 rounded-full object-cover border">
            @else
                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                    <i data-feather="user" class="w-5 h-5 text-white"></i>
                </div>
            @endif
            <span class="font-medium">{{ auth('alumni')->user()->name }}</span>
        </a>

        <!-- Mobile Logout -->
        <form action="{{ route('alumni.logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit"
                class="w-full bg-red-500 text-white px-4 py-2 rounded-md text-sm hover:bg-red-600 flex items-center justify-center space-x-2">
                <i data-feather="log-out" class="w-4 h-4"></i>
                <span>Logout</span>
            </button>
        </form>
    </ul>
</div>

<script>
    function toggleNav() {
        document.getElementById('mobileNav').classList.toggle('hidden');
    }
</script>
