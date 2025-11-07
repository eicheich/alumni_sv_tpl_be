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
            <nav>
                @if (Route::has('admin.alumni.index'))
                    <a class="me-3" href="{{ route('admin.alumni.index') }}">Alumni</a>
                @else
                    <a class="me-3" href="{{ url('/admin/alumni') }}">Alumni</a>
                @endif
                @if (Route::has('admin.dashboard.index'))
                    <a class="me-3" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                @endif
            </nav>
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

    @stack('scripts')
</body>

</html>
