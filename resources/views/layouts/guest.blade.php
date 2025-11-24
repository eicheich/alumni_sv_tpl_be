<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Alumni TPL')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/asset/icon.ico') }}">

    {{-- Bootstrap CDN --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}


    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Feather Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Optional app CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    @stack('head')
</head>

<body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @include('components.landing-header')

    <main class="bg-gray-100">
        {{-- centralized session / validation messages --}}
        @include('layouts.session-status')

        {{-- Page content goes here --}}
        @yield('content')
    </main>

    {{-- Bootstrap JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

    {{-- Optional app JS --}}
    @if (file_exists(public_path('js/app.js')))
        <script src="{{ asset('js/app.js') }}"></script>
    @endif

    <script>
        feather.replace();

        AOS.init();
    </script>

    @stack('scripts')
</body>

</html>
