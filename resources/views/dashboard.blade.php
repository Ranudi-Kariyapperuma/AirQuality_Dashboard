@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Air Quality Dashboard</h1>
            <div id="map"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize the map centered on Colombo
        const map = L.map('map').setView([6.9271, 79.8612], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // AQI color scale
        const aqiColors = {
            'Good': '#00e400',
            'Moderate': '#ffff00',
            'Unhealthy for Sensitive Groups': '#ff7e00',
            'Unhealthy': '#ff0000',
            'Very Unhealthy': '#8f3f97',
            'Hazardous': '#7e0023',
            'No Data': '#808080'
        };

        // Add legend
        const legend = L.control({position: 'bottomright'});
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'aqi-legend');
            let labels = [];
            for (const [category, color] of Object.entries(aqiColors)) {
                labels.push(
                    `<i style="background:${color}"></i> ${category}`
                );
            }
            div.innerHTML = labels.join('<br>');
            return div;
        };
        legend.addTo(map);

        // Fetch sensors and add markers
        fetch('/api/sensors')
            .then(response => response.json())
            .then(sensors => {
                sensors.forEach(sensor => {
                    const color = sensor.latest_reading 
                        ? getAqiColor(sensor.latest_reading.aqi)
                        : aqiColors['No Data'];
                    
                    const marker = L.circleMarker(
                        [sensor.latitude, sensor.longitude],
                        {
                            radius: 10,
                            fillColor: color,
                            color: '#000',
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 0.8
                        }
                    ).addTo(map);

                    const popupContent = sensor.latest_reading
                        ? `
                            <h5>${sensor.name}</h5>
                            <p>AQI: ${sensor.latest_reading.aqi}</p>
                            <p>Category: ${getAqiCategory(sensor.latest_reading.aqi)}</p>
                            <canvas id="chart-${sensor.id}" width="200" height="100"></canvas>
                        `
                        : `
                            <h5>${sensor.name}</h5>
                            <p>No readings available</p>
                        `;

                    marker.bindPopup(popupContent);

                    if (sensor.latest_reading) {
                        // Fetch and display historical data
                        fetch(`/api/sensors/${sensor.id}/readings`)
                            .then(response => response.json())
                            .then(readings => {
                                const ctx = document.getElementById(`chart-${sensor.id}`).getContext('2d');
                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: readings.map(r => r.date),
                                        datasets: [{
                                            label: 'AQI',
                                            data: readings.map(r => r.avg_aqi),
                                            borderColor: color,
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                    }
                });
            });

        function getAqiCategory(aqi) {
            if (aqi <= 50) return 'Good';
            if (aqi <= 100) return 'Moderate';
            if (aqi <= 150) return 'Unhealthy for Sensitive Groups';
            if (aqi <= 200) return 'Unhealthy';
            if (aqi <= 300) return 'Very Unhealthy';
            return 'Hazardous';
        }

        function getAqiColor(aqi) {
            return aqiColors[getAqiCategory(aqi)];
        }
    </script>
@endpush 