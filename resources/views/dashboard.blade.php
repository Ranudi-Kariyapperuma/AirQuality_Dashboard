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
            <iframe id="waqi-map" style="width: 100%; height: calc(100vh - 280px); border: none; border-radius: 12px; overflow: hidden;"
                    src="https://waqi.info/embed/widget/map/?token=31109acafdcb1b5a2715a9e66fbaed7ab9686b0f"></iframe>
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
@endpush
