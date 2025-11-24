<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Alumni')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/asset/icon.ico') }}">

    {{-- Optional app CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- Layout CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/layout.css') }}"> --}}

    {{-- Bootstrap CDN as fallback / quick styling --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}


    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    @stack('head')
</head>

<body class="font-sans text-gray-800 bg-gray-100">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <div class="flex min-h-screen">

        @if (auth()->check())
            @include('layouts.sidebar')
        @endif

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            @if (auth()->check())
                @include('layouts.header')
            @endif

            <!-- Main Content -->
            <main class="p-6 flex-1">

                {{-- centralized session / validation messages --}}
                @include('layouts.session-status')

                {{-- Page content goes here --}}
                @yield('content')

            </main>

            @if (auth()->check())
                @include('layouts.footer')
            @endif
        </div>
    </div>



    {{-- Optional app JS --}}
    @if (file_exists(public_path('js/app.js')))
        <script src="{{ asset('js/app.js') }}"></script>
    @endif

    {{-- Bootstrap JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6V9E+0U5y5L2e3z6Z6b6Y5m1Yk2Kf0b6tQZ6f5Q5m9ct" crossorigin="anonymous">
    </script>

    <script>
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

    <script>
        // Initialize Feather icons dan AOS setelah DOM loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            if (typeof AOS !== 'undefined') {
                AOS.init();
            }
        });

        // Re-initialize feather icons setelah load complete (untuk memastikan)
        window.addEventListener('load', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>

</html>
