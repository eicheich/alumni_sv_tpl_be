@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Chart Card -->
    <h2 class="text-2xl font-semibold">Dashboard</h2>
    <div class="bg-white rounded-2xl shadow p-6 my-6">
        <div class="flex justify-between">
            <p class="font-semibold text-lg">Jumlah alumni</p>

            <select class="border rounded px-3 py-1 text-sm">
                <option>2024</option>
                <option>2023</option>
                <option>2022</option>
            </select>
        </div>

        <!-- Chart placeholder -->
        <div class="h-64 bg-purple-100 rounded-xl mt-4 flex items-center justify-center text-purple-600">
            Chart Area
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-6">
        <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Alumni</p>
                <p class="text-3xl font-bold">5.000</p>

                <p class="text-sm text-green-500 mt-2 flex items-center gap-1">
                <span>📈</span> 8.5% meningkat dalam setahun
                </p>
            </div>

            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-2xl">
                👥
            </div>
        </div>
    </div>

    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard Admin</h1>
                        
    </div> --}}

    <!-- Statistics Cards Row -->
    {{-- <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Alumni</h6>
                            <h3 class="mb-0">{{ $totalAlumni }}</h3>
                        </div>
                        <div class="bg-primary text-white rounded-circle p-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="users" style="width: 28px; height: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Sudah Aktivasi</h6>
                            <h3 class="mb-0 text-success">{{ $activeAlumni }}</h3>
                        </div>
                        <div class="bg-success text-white rounded-circle p-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="check-circle" style="width: 28px; height: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Belum Aktivasi</h6>
                            <h3 class="mb-0 text-warning">{{ $inactiveAlumni }}</h3>
                        </div>
                        <div class="bg-warning text-white rounded-circle p-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="alert-circle" style="width: 28px; height: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Alumni Berkarir</h6>
                            <h3 class="mb-0 text-info">{{ $alumniWithCareer }}</h3>
                        </div>
                        <div class="bg-info text-white rounded-circle p-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="briefcase" style="width: 28px; height: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Chart Row -->
    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0">
                        <i data-feather="bar-chart-2"
                            style="width: 18px; height: 18px; margin-right: 8px; vertical-align: middle;"></i>
                        Perkembangan Jumlah Alumni per Tahun Lulus
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="alumniChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            // Chart.js configuration for alumni by year
            const ctx = document.getElementById('alumniChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Total Alumni',
                            data: {!! json_encode($chartData) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
