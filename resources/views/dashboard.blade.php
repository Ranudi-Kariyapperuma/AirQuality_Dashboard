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

console.log("Fetching sensor data...");

// Fetch sensors and add markers
fetch('/api/sensors')
    .then(response => {
        console.log("API Response status:", response.status);
        if (!response.ok) {
            throw new Error(`API response error: ${response.status}`);
        }
        return response.json();
    })
    .then(sensors => {
        console.log("Received sensors data:", sensors);
        
        if (!sensors || sensors.length === 0) {
            console.warn("No sensors data received");
            return;
        }
        
        sensors.forEach(sensor => {
            console.log("Processing sensor:", sensor.name);
            
            // Add a simple marker for testing
            const testMarker = L.marker([sensor.latitude, sensor.longitude])
                .addTo(map)
                .bindPopup(`Test marker: ${sensor.name}`);
            
            const color = sensor.latest_reading 
                ? getAqiColor(sensor.latest_reading.aqi)
                : aqiColors['No Data'];
            
            console.log(`Sensor ${sensor.name} - Color: ${color}`);
            
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

            marker.on('click', function() {
                console.log(`Marker clicked: ${sensor.name}`);
                
                if (sensor.latest_reading) {
                    // First show basic info popup
                    const popupContent = `
                        <div class="popup-content">
                            <h5>${sensor.name}</h5>
                            <p class="aqi-value">AQI: ${sensor.latest_reading.aqi}</p>
                            <p class="aqi-category">${getAqiCategory(sensor.latest_reading.aqi)}</p>
                            <div class="pollutant-details">
                                <p>PM2.5: ${sensor.latest_reading.pm25 || sensor.latest_reading.pm2_5} µg/m³</p>
                                <p>PM10: ${sensor.latest_reading.pm10} µg/m³</p>
                                <p>Last updated: ${new Date(sensor.latest_reading.reading_time || sensor.latest_reading.created_at).toLocaleString()}</p>
                            </div>
                            <div class="chart-container" style="height: 150px; width: 100%;">
                                <canvas id="chart-${sensor.id}"></canvas>
                            </div>
                        </div>
                    `;
                    
                    marker.bindPopup(popupContent).openPopup();
                    
                    // Then fetch historical data and create chart
                    fetch(`/api/sensors/${sensor.id}/history?hours=24`)
                        .then(response => response.json())
                        .then(historyData => {
                            console.log(`Received history data for ${sensor.name}:`, historyData);
                            createChart(`chart-${sensor.id}`, historyData);
                        })
                        .catch(err => console.error(`Error fetching history for ${sensor.name}:`, err));
                } else {
                    marker.bindPopup(`
                        <div class="popup-content">
                            <h5>${sensor.name}</h5>
                            <p>No readings available</p>
                        </div>
                    `).openPopup();
                }
            });
        });
    })
    .catch(error => {
        console.error("Error fetching sensors:", error);
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
    if (aqi <= 50) return '#00e400'; // Green - Good
    if (aqi <= 100) return '#ffff00'; // Yellow - Moderate
    if (aqi <= 150) return '#ff7e00'; // Orange - Unhealthy for Sensitive Groups
    if (aqi <= 200) return '#ff0000'; // Red - Unhealthy
    if (aqi <= 300) return '#99004c'; // Purple - Very Unhealthy
    return '#7e0023'; // Maroon - Hazardous
}
// Add test markers with hardcoded data
function addTestMarkers() {
    console.log("Adding test markers");
    
    const testData = [
        {
            name: "City Center",
            latitude: 6.9271, 
            longitude: 79.8612,
            aqi: 75,
            pm25: 35.5,
            pm10: 45.2
        },
        {
            name: "Port Area",
            latitude: 6.9400, 
            longitude: 79.8500,
            aqi: 120,
            pm25: 50.2,
            pm10: 75.8
        },
        {
            name: "Residential Zone",
            latitude: 6.9100, 
            longitude: 79.8700,
            aqi: 45,
            pm25: 20.3,
            pm10: 35.1
        },
        // Additional areas with different AQI levels to show color range
        {
            name: "Dehiwala",
            latitude: 6.8504,
            longitude: 79.8650,
            aqi: 25,
            pm25: 10.2,
            pm10: 22.5
        },
        {
            name: "Malabe",
            latitude: 6.9057,
            longitude: 79.9576,
            aqi: 160,
            pm25: 62.1,
            pm10: 88.3
        },
        {
            name: "Mount Lavinia",
            latitude: 6.8378,
            longitude: 79.8629,
            aqi: 55,
            pm25: 25.4,
            pm10: 38.7
        },
        {
            name: "Kolonnawa",
            latitude: 6.9333,
            longitude: 79.8889,
            aqi: 210,
            pm25: 87.3,
            pm10: 110.5
        },
        {
            name: "Kotte",
            latitude: 6.8903,
            longitude: 79.9034,
            aqi: 95,
            pm25: 42.8,
            pm10: 58.4
        },
        {
            name: "Homagama",
            latitude: 6.8431,
            longitude: 80.0025,
            aqi: 310,
            pm25: 112.5,
            pm10: 165.2
        },
        {
            name: "Nugegoda",
            latitude: 6.8524,
            longitude: 79.8976,
            aqi: 45, 
            pm25: 22.5,
            pm10: 30.2,
        }
        
    ];
    
    
    testData.forEach(location => {
        const color = getAqiColor(location.aqi);
        
        const marker = L.circleMarker(
            [location.latitude, location.longitude],
            {
                radius: 10,
                fillColor: color,
                color: '#000',
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8
            }
        ).addTo(map);
        
        marker.bindPopup(`
            <div class="popup-content">
                <h5>${location.name}</h5>
                <p class="aqi-value">AQI: ${location.aqi}</p>
                <p class="aqi-category">${getAqiCategory(location.aqi)}</p>
                <div class="pollutant-details">
                    <p>PM2.5: ${location.pm25} µg/m³</p>
                    <p>PM10: ${location.pm10} µg/m³</p>
                    <p>Last updated: ${new Date().toLocaleString()}</p>
                </div>
            </div>
        `);
    });
}

// Call this function after map initialization
addTestMarkers();

    // Handle search functionality
    const searchInput = document.querySelector('.location-search');
    searchInput.addEventListener('input', function(e) {
        // Add your search logic here
        console.log('Searching for:', e.target.value);
    });
</script>
@endpush 
