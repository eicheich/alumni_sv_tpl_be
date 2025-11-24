<!-- Sidebar -->
@if (auth()->check())
    <aside class="w-64 h-screen bg-white border-r hidden md:flex flex-col sticky top-0">
        <div class="flex-1 overflow-y-auto">
            <div class="p-6 font-bold text-xl text-purple-600">AlumniTPL</div>

            <nav class="mt-4">
                @if (Route::has('admin.dashboard.index'))
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="block flex py-3 px-6 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard.*') ? 'bg-purple-600 text-white rounded-r-md hover:bg-purple-800' : '' }}">
                        <i data-feather="home" class="mr-2"></i>
                        Dasbor
                    </a>
                @endif

                @if (Route::has('admin.alumni.index'))
                    <a href="{{ route('admin.alumni.index') }}"
                        class="block flex py-3 px-6 hover:bg-gray-100 {{ request()->routeIs('admin.alumni.*') ? 'bg-purple-600 text-white rounded-r-md hover:bg-purple-800' : '' }}">
                        <i data-feather="users" class="mr-2"></i>
                        Data Alumni</a>
                @else
                    <a href="{{ route('admin.alumni.index') }}"
                        class="block flex py-3 px-6 hover:bg-gray-100 {{ request()->is('admin/alumni*') ? 'bg-purple-600 text-white rounded-r-md hover:bg-purple-800' : '' }}">
                        <i data-feather="users" class="mr-2"></i>
                        Data Alumni</a>
                @endif

                @if (Route::has('admin.information.index'))
                    <a href="{{ route('admin.information.index') }}"
                        class="block flex py-3 px-6 hover:bg-gray-100 {{ request()->routeIs('admin.information.*') ? 'bg-purple-600 text-white rounded-r-md hover:bg-purple-800' : '' }}">
                        <i data-feather="info" class="mr-2"></i>
                        Informasi Umum</a>
                @endif


                @if (Route::has('admin.outstanding-alumni.index'))
                    <a href="{{ route('admin.outstanding-alumni.index') }}"
                        class="block flex py-3 px-6 hover:bg-gray-100 {{ request()->routeIs('admin.outstanding-alumni.*') ? 'bg-purple-600 text-white rounded-r-md hover:bg-purple-800' : '' }}">
                        <i data-feather="award" class="mr-2"></i>
                        Alumni Berprestasi</a>
                @endif



            </nav>
        </div>

        <div class="border-t bg-white">
            <a href="#" onclick="event.preventDefault();"
                class="block flex items-center py-3 px-6 hover:bg-gray-100">
                <i data-feather="settings" class="mr-2"></i>
                Settings</a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full py-3 px-6 hover:bg-gray-100">
                    <i data-feather="log-out" class="mr-2"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
@endif
