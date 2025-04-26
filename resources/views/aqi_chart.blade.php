<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index (Last 7 Days)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0"></script>

</head>
<body>

    <h1>Air Quality Index (Last 7 Days)</h1>

    <canvas id="aqiChart" width="800" height="400"></canvas>
  
<pre>{{ json_encode($chartData, JSON_PRETTY_PRINT) }}</pre>
   
<script>
async function fetchAqiData() {
    const response = await fetch('/api/aqi-data');
    const chartData = await response.json();

    const datasets = chartData.map(sensor => ({
        label: sensor.sensor_name,
        data: sensor.data,
        borderColor: randomColor(),
        fill: false,
    }));

    const ctx = document.getElementById('aqiChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'AQI Value'
                    }
                }
            }
        }
    });
}

// Helper to random colors
function randomColor() {
    return '#' + Math.floor(Math.random()*16777215).toString(16);
}

fetchAqiData();
</script>

</body>
</html>