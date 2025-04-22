<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Colombo Air Quality Dashboard')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { height: 600px; }
        .aqi-legend {
            padding: 10px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .aqi-legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .content {
            min-height: calc(100vh - 60px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Colombo Air Quality Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/sensors') }}">Sensors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/reports') }}">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <footer class="bg-dark text-white mt-5 py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <h6 class="mb-1">&copy; {{ date('Y') }} Colombo Air Quality Monitoring System</h6>
                <small class="text-muted">Done By Group 62</small>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">Last updated: {{ now()->format('F j, Y \a\t h:i A') }}</p>
            </div>
        </div>
    </div>
</footer>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html> 