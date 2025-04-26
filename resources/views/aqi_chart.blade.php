<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index (Last 7 Days)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0"></script>
<style>
/* Dashboard Styles */
.dashboard-container {
    padding: 0;
    max-width: 100%;
}

.content-wrapper {
    padding: 2rem 4rem;
}

.dashboard-header {
    margin-bottom: 2rem;
}

.dashboard-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.subtitle {
    color: #666;
    font-size: 1.1rem;
}

.map-section {
    position: relative;
    height: calc(100vh - 280px);
    background: #f0f5f9;
    border-radius: 12px;
    overflow: hidden;
}

.search-container {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 600px;
    z-index: 1000;
}

.location-search {
    width: 100%;
    padding: 12px 40px;
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    font-size: 1rem;
}

#map {
    height: 100%;
    width: 100%;
}

.map-controls {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.control-btn {
    width: 40px;
    height: 40px;
    background: white;
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.control-btn:hover {
    background: #f8f9fa;
}

.refresh-text {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255,255,255,0.9);
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 0.9rem;
    color: #666;
}
.popup-content {
    min-width: 250px;
    padding: 5px;
}

.popup-content h5 {
    margin-top: 0;
    margin-bottom: 5px;
    font-weight: 600;
}

.aqi-value {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 2px;
}

.aqi-category {
    font-weight: 500;
    margin-bottom: 8px;
}

.pollutant-details {
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.pollutant-details p {
    margin: 3px 0;
}

.chart-container {
    margin-top: 10px;
    border-top: 1px solid #eee;
    padding-top: 10px;
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 1rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
    }

    .map-section {
        height: calc(100vh - 220px);
    }
}
</style>


</head>
<body>

    <h1>Air Quality Index (Last 7 Days)</h1>

    <canvas id="aqiChart" width="800" height="400"></canvas>
  
<pre>{{ json_encode($chartData, JSON_PRETTY_PRINT) }}</pre>
   
<script>
    var ctx = document.getElementById('aqiChart').getContext('2d');
    var aqiChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [
                @foreach ($chartData as $data)
                    {
                        label: "{{ $data['label'] }}",
                        data: {!! json_encode($data['data']) !!},
                        borderColor: "{{ $data['borderColor'] }}",
                        fill: false
                    },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            //parsing:false,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day', // You can use 'minute', 'hour', 'day', etc.
                        //tooltipFormat: 'll', // You can change this to suit the format you need
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {     
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Air Quality Index (AQI)'
                    }
                }
            }
        }
    });
</script>


</body>
</html>