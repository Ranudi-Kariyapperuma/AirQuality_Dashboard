<!DOCTYPE html>
<html>
<head>
    <title>Air Quality Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Air Quality Index (Last 7 Days)</h2>

    <canvas id="aqiChart" width="800" height="400"></canvas>

    <script>
        const chartData = @json($chartData);

        const ctx = document.getElementById('aqiChart').getContext('2d');
        const aqiChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: chartData
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'YYYY-MM-DD HH:mm'
                        },
                        title: {
                            display: true,
                            text: 'Date & Time'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'AQI Value'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    </script>
</body>
</html>
