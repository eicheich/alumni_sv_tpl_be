<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Alumni TPL')</title>

    {{-- Bootstrap CDN --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}


    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- Feather Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Optional app CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    @stack('head')
</head>

<body>
    <main>
        {{-- centralized session / validation messages --}}
        @include('layouts.session-status')

        {{-- Page content goes here --}}
        @yield('content')
    </main>

    {{-- Bootstrap JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6V9E+0U5y5L2e3z6Z6b6Y5m1Yk2Kf0b6tQZ6f5Q5m9ct" crossorigin="anonymous">
    </script>

    {{-- Optional app JS --}}
    @if (file_exists(public_path('js/app.js')))
        <script src="{{ asset('js/app.js') }}"></script>
    @endif

    <script>
        feather.replace();
    </script>

    @stack('scripts')
</body>

</html>
