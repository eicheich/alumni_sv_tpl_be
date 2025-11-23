{{-- Centralized session / validation messages --}}
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
    $types = ['success' => 'green-500', 'error' => 'red-500', 'warning' => 'yellow-500', 'info' => 'blue-500'];
@endphp

@foreach ($types as $key => $bs)
    @if (session($key))
        {{-- <div class="alert alert-{{ $bs }} alert-dismissible fade show" role="alert">
            {!! session($key) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}

        
        <!-- Checkbox untuk toggle (disembunyikan) -->
        <input type="checkbox" id="close-alert" class="peer hidden" />

        <!-- Alert -->
        <div class="peer-checked:hidden bg-{{ $bs }} text-white px-4 my-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{!! session($key) !!}!</strong>
            {{-- <span class="block sm:inline">Anda berhasil login.</span> --}}

            <!-- Tombol close -->
            <label for="close-alert" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
            <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
            </svg>
            </label>
        </div>


    @endif
@endforeach

@if (isset($errors) && $errors->any())
    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>There were some problems with your input:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}

    <!-- Checkbox untuk toggle (disembunyikan) -->
    <input type="checkbox" id="close-alert" class="peer hidden" />

    <!-- Alert -->
    <div class="peer-checked:hidden bg-red-500 text-white px-4 py-3 my-4 rounded relative" role="alert">
        <strong class="font-bold">There were some problems with your input:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <!-- Tombol close -->
        <label for="close-alert" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
        <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
        </svg>
        </label>
    </div>
@endif
