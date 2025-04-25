<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index (Last 7 Days)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@1.0.0"></script>
</head>
<body>

    <h1>Air Quality Index (Last 7 Days)</h1>

    <canvas id="aqiChart" width="400" height="200"></canvas>
    
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
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day', // You can use 'minute', 'hour', 'day', etc.
                        tooltipFormat: 'll', // You can change this to suit the format you need
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
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