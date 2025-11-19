<header class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('index') }}">
            <span style="vertical-align: middle;">Alumni TPL</span>
        </a>

        <!-- Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tentang">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#informasi">Informasi Umum</a>
                </li>

                <!-- Alumni Profile Link -->
                <li class="nav-item ms-3">
                    <a class="nav-link d-flex align-items-center" href="{{ route('alumni.profile') }}" title="Profile">
                        @if (auth('alumni')->user()->photo_profile)
                            <img src="{{ asset('storage/' . auth('alumni')->user()->photo_profile) }}"
                                alt="{{ auth('alumni')->user()->name }}" class="rounded-circle"
                                style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;">
                                <i data-feather="user" style="width: 16px; height: 16px; color: white;"></i>
                            </div>
                        @endif
                    </a>
                </li>

                <!-- Logout Button -->
                <li class="nav-item ms-2">
                    <form action="{{ route('alumni.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i data-feather="log-out" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
