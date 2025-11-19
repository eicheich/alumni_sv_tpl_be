@if (auth()->check())
    <aside class="sidebar">
        <nav class="nav flex-column sidebar-main-menu">
            <div class="nav-section-title">Main Menu</div>

            @if (Route::has('admin.dashboard.index'))
                <a class="nav-link {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard.index') }}">
                    <i data-feather="home"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            @if (Route::has('admin.alumni.index'))
                <a class="nav-link {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}"
                    href="{{ route('admin.alumni.index') }}">
                    <i data-feather="users"></i>
                    <span>Alumni</span>
                </a>
            @else
                <a class="nav-link {{ request()->is('admin/alumni*') ? 'active' : '' }}"
                    href="{{ url('/admin/alumni') }}">
                    <i data-feather="users"></i>
                    <span>Alumni</span>
                </a>
            @endif

            @if (Route::has('admin.information.index'))
                <a class="nav-link {{ request()->routeIs('admin.information.*') ? 'active' : '' }}"
                    href="{{ route('admin.information.index') }}">
                    <i data-feather="info"></i>
                    <span>Informasi</span>
                </a>
            @endif
        </nav>

        <nav class="nav flex-column sidebar-bottom-menu">
            <div class="nav-section-title">Settings</div>

            <a class="nav-link" href="#" onclick="event.preventDefault();">
                <i data-feather="settings"></i>
                <span>Pengaturan</span>
            </a>

            <form class="nav-link p-0 m-0 border-0" action="{{ route('admin.logout') }}" method="POST"
                style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem !important;">
                @csrf
                <button type="submit"
                    style="background: none; border: none; padding: 0; color: #2c3e50; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; width: 100%; transition: all 0.3s ease;">
                    <i data-feather="log-out" style="width: 18px; height: 18px;"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>
@endif
