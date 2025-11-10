<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Alumni')</title>

    {{-- Optional app CSS --}}
    @if (file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

    {{-- Bootstrap CDN as fallback / quick styling --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    @stack('head')
</head>

<body>
    <header class="bg-light border-bottom mb-3">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <a class="navbar-brand mb-0 h1" href="{{ url('/') }}">Alumni SV</a>
            @if (auth()->check())
                <nav>
                    @if (Route::has('admin.alumni.index'))
                        <a class="me-3" href="{{ route('admin.alumni.index') }}">Alumni</a>
                    @else
                        <a class="me-3" href="{{ url('/admin/alumni') }}">Alumni</a>
                    @endif
                    @if (Route::has('admin.information.index'))
                        <a class="me-3" href="{{ route('admin.information.index') }}">Informasi</a>
                    @endif
                    @if (Route::has('admin.dashboard.index'))
                        <a class="me-3" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                    @endif
                    <span class="text-muted">Logged in as {{ auth()->user()->name }}</span>
                    <span class="text-muted"> | </span>
                    <form class="d-inline" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Logout</button>
                    </form>
                </nav>
            @endif
        </div>
    </header>

    <main class="container">
        {{-- centralized session / validation messages --}}
        @include('layouts.session-status')

        {{-- Page content goes here --}}
        @yield('content')
    </main>

    <footer class="bg-white border-top mt-5 py-3">
        <div class="container text-center text-muted">
            &copy; {{ date('Y') }} Alumni SV TPL
        </div>
    </footer>

    {{-- Optional app JS --}}
    @if (file_exists(public_path('js/app.js')))
        <script src="{{ asset('js/app.js') }}"></script>
    @endif

    {{-- Bootstrap JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6V9E+0U5y5L2e3z6Z6b6Y5m1Yk2Kf0b6tQZ6f5Q5m9ct" crossorigin="anonymous">
    </script>

    <script>
        // Global handler: make data-bs-toggle="modal" work even if Bootstrap JS didn't initialize
        document.addEventListener('click', function(e) {
            const toggle = e.target.closest('[data-bs-toggle="modal"]');
            if (toggle) {
                e.preventDefault();
                const target = toggle.getAttribute('data-bs-target');
                const modalEl = document.querySelector(target);
                if (!modalEl) return;
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    try {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                        return;
                    } catch (err) {
                        console.error('bootstrap show failed', err);
                    }
                }
                // Fallback show
                try {
                    modalEl.classList.add('show');
                    modalEl.style.display = 'block';
                    modalEl.setAttribute('aria-modal', 'true');
                    modalEl.removeAttribute('aria-hidden');
                    document.body.classList.add('modal-open');
                    // add backdrop
                    let backdrop = document.querySelector('.modal-backdrop');
                    if (!backdrop) {
                        backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                } catch (err) {
                    console.error('fallback show failed', err);
                }
                return;
            }

            // Global handler: make data-bs-dismiss="modal" work even if Bootstrap JS didn't initialize
            const dismiss = e.target.closest('[data-bs-dismiss="modal"]');
            if (!dismiss) return;
            const modalEl = dismiss.closest('.modal');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                try {
                    bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                    return;
                } catch (err) {
                    console.error('bootstrap hide failed', err);
                }
            }
            // Fallback hide
            try {
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
                modalEl.setAttribute('aria-hidden', 'true');
                modalEl.removeAttribute('aria-modal');
                document.body.classList.remove('modal-open');
                // remove backdrops
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            } catch (err) {
                console.error('fallback hide failed', err);
            }
        });

        // Also allow clicking on backdrop to close when using fallback
        document.addEventListener('click', function(e) {
            const backdrop = e.target.closest('.modal-backdrop');
            if (!backdrop) return;
            // close any open modal
            document.querySelectorAll('.modal.show').forEach(modalEl => {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    try {
                        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                    } catch (err) {
                        console.error(err);
                    }
                } else {
                    modalEl.classList.remove('show');
                    modalEl.style.display = 'none';
                    modalEl.setAttribute('aria-hidden', 'true');
                    modalEl.removeAttribute('aria-modal');
                    document.body.classList.remove('modal-open');
                }
            });
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
        });
    </script>

    @stack('scripts')
</body>

</html>
