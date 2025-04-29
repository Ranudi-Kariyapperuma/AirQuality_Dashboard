@extends('layouts.app')

@section('title', 'Air Quality Index (Last 7 Days)')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Air Quality Index (Last 7 Days)</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle"></i> This chart shows the Air Quality Index (AQI) readings from the last 7 days for different locations in Colombo.
                    </div>
                    
                    <!-- AQI Level Indicators -->
                    <div class="aqi-levels mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="aqi-level good">
                                    <span class="level-name">Good</span>
                                    <span class="level-range">0-50</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="aqi-level moderate">
                                    <span class="level-name">Moderate</span>
                                    <span class="level-range">51-100</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="aqi-level unhealthy-sensitive">
                                    <span class="level-name">Unhealthy for Sensitive Groups</span>
                                    <span class="level-range">101-150</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="aqi-level unhealthy">
                                    <span class="level-name">Unhealthy</span>
                                    <span class="level-range">151-200</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="aqi-level very-unhealthy">
                                    <span class="level-name">Very Unhealthy</span>
                                    <span class="level-range">201-300</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="aqi-level hazardous">
                                    <span class="level-name">Hazardous</span>
                                    <span class="level-range">301+</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container" style="position: relative; height: 60vh;">
                        <canvas id="aqiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .chart-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
    }
    .alert-info {
        background-color: #e3f2fd;
        border-color: #90caf9;
        color: #0d47a1;
    }
    .aqi-levels {
        margin-bottom: 20px;
    }
    .aqi-level {
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        color: white;
        margin-bottom: 10px;
    }
    .aqi-level .level-name {
        display: block;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .aqi-level .level-range {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    .good { background-color: #00e400; }
    .moderate { background-color: #ffff00; color: #000; }
    .unhealthy-sensitive { background-color: #ff7e00; }
    .unhealthy { background-color: #ff0000; }
    .very-unhealthy { background-color: #8f3f97; }
    .hazardous { background-color: #7e0023; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('aqiChart').getContext('2d');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: chartData
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            const aqi = context.parsed.y;
                            let level = '';
                            if (aqi <= 50) level = 'Good';
                            else if (aqi <= 100) level = 'Moderate';
                            else if (aqi <= 150) level = 'Unhealthy for Sensitive Groups';
                            else if (aqi <= 200) level = 'Unhealthy';
                            else if (aqi <= 300) level = 'Very Unhealthy';
                            else level = 'Hazardous';
                            
                            return `${context.dataset.label}: ${aqi.toFixed(1)} AQI (${level})`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM d'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date',
                        font: {
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'AQI Value',
                        font: {
                            weight: 'bold'
                        }
                    },
                    min: 0,
                    max: 300,
                    ticks: {
                        stepSize: 50
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });
});
</script>
@endpush