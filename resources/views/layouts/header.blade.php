<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Alumni')</title>
    {{-- Optional app CSS (uncomment if exists) --}}
    @if (file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
    <header style="padding:1rem;background:#f5f5f5;border-bottom:1px solid #ddd;">
        <div style="max-width:1100px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;">
            <h2 style="margin:0;font-size:1.25rem"><a href="{{ url('/') }}">My Alumni App</a></h2>
            <nav>
                <a href="{{ route('admin.alumni.index') ?? url('/admin/alumni') }}">Alumni</a>
                {{-- add other links as needed --}}
            </nav>
        </div>
    </header>
    <main style="max-width:1100px;margin:1.5rem auto;padding:0 1rem;min-height:60vh;">
        {{-- header and call css js from bootstrap --}}
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
            <title>@yield('title', 'Dashboard')</title>
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <script src="{{ asset('js/app.js') }}" defer></script>
        </head>

        <body>
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="{{ route('admin.dashboard.index') }}">Alumni SV</a>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.alumni.index') }}">Alumni</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0" action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
                        </form>
                    </div>
                </nav>
            </header>
            <main class="container mt-4">
                @yield('content')
            </main>
        </body>

        </html>
