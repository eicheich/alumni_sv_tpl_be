@extends('layouts.main')

@section('title', 'Register Alumni')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Register sebagai Alumni</h1>
    </div>

    <p>Register sebagai Alumni</p>
    <form action="{{ route('alumni.register') }}" method="POST">
        @csrf
        {{-- email and nim --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
        </div>
        <button type="submit" class="btn btn-primary">Validasi Data</button>
    </form>

@endsection
