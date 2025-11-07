@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Dashboard Admin</h1>
        <a href="#" class="btn btn-primary">Add Alumni</a>
    </div>

    <p>Welcome to the admin dashboard!</p>
    {{-- TODO: replace with a real table listing alumni (name, email, major, nim, photo) --}}

@endsection
