@extends('layouts.app')

@section('title', 'Air Quality Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="dashboard-header">
            <h1>Air Quality Dashboard</h1>
            <p class="subtitle">Real-time monitoring of Colombo's air quality</p>
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
    </div>
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
    // Initialize the map centered on Colombo
    const map = L.map('map', {
        zoomControl: false // Disable default zoom control
    }).setView([6.9271, 79.8612], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

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

                if (sensor.latest_reading) {
                    marker.bindPopup(`
                        <div class="popup-content">
                            <h5>${sensor.name}</h5>
                            <p class="aqi-value">AQI: ${sensor.latest_reading.aqi}</p>
                            <p class="aqi-category">${getAqiCategory(sensor.latest_reading.aqi)}</p>
                            <div class="pollutant-details">
                                <p>PM2.5: ${sensor.latest_reading.pm25} µg/m³</p>
                                <p>PM10: ${sensor.latest_reading.pm10} µg/m³</p>
                                <p>Last updated: ${new Date(sensor.latest_reading.reading_time).toLocaleString()}</p>
                            </div>
                        </div>
                    `);
                } else {
                    marker.bindPopup(`
                        <div class="popup-content">
                            <h5>${sensor.name}</h5>
                            <p>No readings available</p>
                        </div>
                    `);
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

    // Handle search functionality
    const searchInput = document.querySelector('.location-search');
    searchInput.addEventListener('input', function(e) {
        // Add your search logic here
        console.log('Searching for:', e.target.value);
    });
</script>
@endpush 
