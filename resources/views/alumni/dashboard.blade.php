@extends('layouts.main')

@section('title', 'Alumni Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Selamat Datang, {{ auth('alumni')->user()->name }}!</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profil Alumni</h5>
                        <p class="card-text">
                            <strong>Email:</strong> {{ auth('alumni')->user()->email }}<br>
                            <strong>Nomor Telepon:</strong> {{ auth('alumni')->user()->phone }}<br>
                            <strong>Status:</strong> <span class="badge bg-success">Aktif</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('alumni.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection
