@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">Dashboard</h2>

    <!-- Chart Card -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <p class="font-semibold text-lg">Grafik Jumlah Alumni Berdasarkan Angkatan</p>
        </div>

        <div class="h-80">
            <canvas id="alumniChart"></canvas>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Alumni Card -->
        <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Alumni</p>
                <p class="text-3xl font-bold text-purple-600">{{ $totalAlumni }}</p>
                <p class="text-xs text-gray-400 mt-1">Pengguna terdaftar</p>
            </div>
            <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                <i data-feather="users" class="w-7 h-7"></i>
            </div>
        </div>

        <!-- Total Informasi Card -->
        <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Informasi</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalInformation }}</p>
                <p class="text-xs text-gray-400 mt-1">Berita & pengumuman</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                <i data-feather="file-text" class="w-7 h-7"></i>
            </div>
        </div>

        <!-- Total Alumni Berprestasi Card -->
        <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Alumni Berprestasi</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $totalOutstandingAlumni }}</p>
                <p class="text-xs text-gray-400 mt-1">Alumni yang ditampilkan</p>
            </div>
            <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                <i data-feather="award" class="w-7 h-7"></i>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js configuration for alumni by angkatan
            const ctx = document.getElementById('alumniChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Jumlah Alumni',
                            data: {!! json_encode($chartData) !!},
                            backgroundColor: 'rgba(147, 51, 234, 0.1)',
                            borderColor: 'rgba(147, 51, 234, 1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgba(147, 51, 234, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Jumlah: ' + context.parsed.y + ' alumni';
                                    },
                                    title: function(context) {
                                        return 'Angkatan ' + context[0].label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
