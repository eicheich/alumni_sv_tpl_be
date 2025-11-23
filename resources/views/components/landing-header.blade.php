<!-- Navbar -->
<nav class="flex items-center justify-between px-12 py-4 bg-white shadow-sm">
    <div class="font-semibold text-lg flex"><img src="asset/logo.png" class="h-8 mr-2" alt="">Web Alumni TPL</div>
    <ul class="hidden md:flex space-x-6 text-sm font-medium">
        <li><a href="{{route('index')}}" class="{{ request()->routeIs('index') 
                    ? 'text-purple-600 font-semibold' 
                    : 'hover:text-purple-600' }}">Beranda</a></li>
        <li><a href="{{route('information.index')}}" class="{{ request()->routeIs('information.index') 
                    ? 'text-purple-600 font-semibold' 
                    : 'hover:text-purple-600' }}">Informasi Umum</a></li>
    </ul>
    <div class="space-x-2">
        <a href="{{route('alumni.login.view')}}"><button class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">Masuk</button></a>
        <a href="{{route('alumni.validate-data.view')}}"><button class="bg-purple-400 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-500">Daftar</button></a>
    </div>
</nav>