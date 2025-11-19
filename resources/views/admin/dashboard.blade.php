@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard Admin</h1>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row mb-4">
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
    </div>

    <!-- Chart Row -->
    <div class="row">
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
    </div>

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
