@extends('layouts.app')

@section('title', 'Air Quality Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="dashboard-header">
            <h1>Air Quality Dashboard</h1>
            <p class="subtitle">Real-time monitoring of Colombo's air Quality</p>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search for locations" class="location-search">
                </div>
            </div>
            <div id="map"></div>
            <div class="map-controls">
                <button class="control-btn" id="zoomIn">+</button>
                <button class="control-btn" id="zoomOut">−</button>
                <button class="control-btn" id="locate">
                    <i class="fas fa-location-arrow"></i>
                </button>
            </div>
            <p class="refresh-text">Data refreshes every 5 minutes</p>
        </div>
        <!-- Join with Us Section -->
        <div class="join-us-section mt-5 p-4 bg-light rounded shadow">
            <h2 class="text-center mb-3">Join with Us and Measure the Air Quality in Your Neighborhood</h2>
            <p class="text-center">To connect and start measuring air quality, you'll need an air quality monitoring device and an internet connection.</p>
            
            <div class="text-center mb-4">
                <img src="{{ asset('images/air1.png') }}" alt="GAIA Kit Components" style="max-width:100%;height:auto;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);">
            </div>

            <div class="setup-info mt-4">
                <h3 class="text-center mb-3">How to Setup</h3>
                <p class="text-center">
                    Follow the detailed setup guide available <a href="https://aqicn.org/gaia/a18/" target="_blank" class="text-primary">here</a>.
                </p>
            </div>

            <div class="learn-more mt-4 text-center">
                <h3 class="mb-3">Want to Know More?</h3>
                <p>
                    Discover more about air quality monitoring on the <a href="https://aqicn.org/gaia/overview/" target="_blank" class="text-primary">GAIA Overview Page</a>.
                </p>
            </div>

            <div class="learn-more mt-4 text-center">
                <h3 class="mb-3">How to buy it</h3>
                <p>
                     <a href="https://aqicn.org/gaia/overview/" target="_blank" class="text-primary">GAIA Overview Page</a>.
                </p>
            </div>
    </div>
</div>

<div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
    <a href="{{ route('about') }}">
        <button style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
            View AQI Chart
        </button>
    </a>
</div>

@endsection



@push('styles')
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

.sensor-marker {
    color: white;
    font-weight: bold;
    text-align: center;
    border-radius: 4px;
    padding: 5px 10px;
    min-width: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.popup-content {
    padding: 10px;
}

.popup-title {
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 5px;
}

.popup-description {
    font-size: 14px;
    margin-bottom: 10px;
}

.popup-readings {
    font-size: 14px;
    margin-top: 10px;
}

.popup-readings table {
    width: 100%;
    border-collapse: collapse;
}

.popup-readings th, .popup-readings td {
    padding: 4px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.popup-aqi {
    font-weight: bold;
    font-size: 16px;
    margin-top: 5px;
    padding: 4px 8px;
    border-radius: 4px;
    display: inline-block;
    color: white;
}

.aqi-legend {
    background: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    line-height: 1.8;
}

.aqi-legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
    border-radius: 2px;
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
@endpush


@push('scripts')
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
<script>
// Debug: Log when script starts
console.log("Map script started");

// Initialize the map centered on Colombo
const map = L.map('map', {
    zoomControl: false // Disable default zoom control
}).setView([6.9271, 79.8612], 12);

console.log("Map initialized");

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Get sensor and air quality data from PHP
const sensors = @json($sensors);
const airQualityReadings = @json($airQualityReadings ?? []);

// AQI color scale and functions

}

function getAqiColor(aqi) {
    if (aqi <= 50) return '#00e400'; // Green - Good
    if (aqi <= 100) return '#ffff00'; // Yellow - Moderate
    if (aqi <= 150) return '#ff7e00'; // Orange - Unhealthy for Sensitive Groups
    if (aqi <= 200) return '#ff0000'; // Red - Unhealthy
    if (aqi <= 300) return '#99004c'; // Purple - Very Unhealthy
    return '#7e0023'; // Maroon - Hazardous
}

// Create markers for each sensor
sensors.forEach(sensor => {
    // Find corresponding air quality reading for this sensor by matching sensor.id with reading.sensor_id
    const reading = airQualityReadings.find(r => r.sensor_id == sensor.id);
    
    // Get the AQI color based on reading
    const aqi = reading ? reading.aqi : null;
    const aqiColor = aqi ? getAqiColor(aqi) : '#808080';
    const aqiCategory = aqi ? getAqiCategory(aqi) : 'No Data';
    
    // Create a custom HTML element for the marker
    const markerHtml = `<div class="sensor-marker" style="background-color: ${aqiColor}">${sensor.sensor_id}</div>`;
    const customIcon = L.divIcon({
        html: markerHtml,
        className: '',
        iconSize: [80, 40],
        iconAnchor: [40, 20]
    });

    // Create marker with the custom icon
    const marker = L.marker([sensor.latitude, sensor.longitude], {
        icon: customIcon
    }).addTo(map);

    // Create popup content
    let popupContent = `
        <div class="popup-content">
            <div class="popup-title">${sensor.name}</div>
            <div class="popup-description">${sensor.description}</div>
    `;
    
    if (reading) {
        popupContent += `
            <div class="popup-aqi" style="background-color: ${aqiColor}">AQI: ${reading.aqi} (${aqiCategory})</div>
            <div class="popup-readings">
                <table>
                    <tr><th>Pollutant</th><th>Value</th></tr>
                    <tr><td>PM2.5</td><td>${reading.pm25.toFixed(1)} μg/m³</td></tr>
                    <tr><td>PM10</td><td>${reading.pm10.toFixed(1)} μg/m³</td></tr>
                    <tr><td>CO</td><td>${reading.co.toFixed(1)} ppm</td></tr>
                    <tr><td>NO₂</td><td>${reading.no2.toFixed(1)} ppb</td></tr>
                    <tr><td>O₃</td><td>${reading.o3.toFixed(1)} ppb</td></tr>
                    <tr><td>SO₂</td><td>${reading.so2.toFixed(1)} ppb</td></tr>
                    <tr><td>Last Updated</td><td>${new Date(reading.created_at).toLocaleString()}</td></tr>
                </table>
            </div>
        `;
    } else {
        popupContent += `
            <div class="popup-aqi" style="background-color: #808080">No Data Available</div>
        `;
    }
    
    popupContent += `</div>`;

    // Bind popup to marker
    marker.bindPopup(popupContent, {
        maxWidth: 30000
    });
});

// Custom zoom controls
document.getElementById('zoomIn').addEventListener('click', () => {
    map.zoomIn();
});

document.getElementById('zoomOut').addEventListener('click', () => {
    map.zoomOut();
});

document.getElementById('locate').addEventListener('click', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            map.setView([position.coords.latitude, position.coords.longitude], 15);
        });
    }
});

// Add legend
const aqiColors = {
    'Good': '#00e400',
    'Moderate': '#ffff00',
    'Unhealthy for Sensitive Groups': '#ff7e00',
    'Unhealthy': '#ff0000',
    'Very Unhealthy': '#8f3f97',
    'Hazardous': '#7e0023',
    'No Data': '#808080'
};

const legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'aqi-legend');
    let labels = [];
    
    div.innerHTML = '<strong>Air Quality Index</strong><br>';
    
    for (const [category, color] of Object.entries(aqiColors)) {
        labels.push(
            `<i style="background:${color}"></i> ${category}`
        );
    }
    
    div.innerHTML += labels.join('<br>');
    return div;
};
legend.addTo(map);
</script>
@endpush
