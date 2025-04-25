<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Air Quality Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
            background-color: #87CEEB !important; /* Light blue color */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #2c3e50 !important; /* Darker text for better contrast */
            font-weight: 500;
        }
        .nav-link:hover {
            color: #1a2634 !important;
        }
        .nav-link.active {
            color: #1a2634 !important;
            font-weight: 600;
        }
        .content {
            min-height: calc(100vh - 60px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 20px;
        }
        .about-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
    </style>
     @stack('styles')
</head>
<body>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <span class="brand-icon">*</span>
                    BreatheSafe Colombo
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('reports') ? 'active' : '' }}" href="{{ url('/reports') }}">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ url('/login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <section class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12 text-center">
                    <h1 class="display-4 mb-4"><b>About Air Quality Dashboard</b></h1>
                    <p class="lead">Real-time air quality monitoring and analysis platform</p>
                </div>
            </div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-speedometer2 feature-icon"></i>
                <h5 class="card-title">Real-time Monitoring</h5>
                <p class="card-text">Track air quality parameters in real-time with our advanced sensor network.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-graph-up feature-icon"></i>
                <h5 class="card-title">Data Analysis</h5>
                <p class="card-text">Comprehensive analysis of air quality data with interactive visualizations.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-bell feature-icon"></i>
                <h5 class="card-title">Alert System</h5>
                <p class="card-text">Get instant notifications when air quality parameters exceed safe levels.</p>
            </div>
        </div>
    </div>
</div>


            <div class="row mb-5">
                <div class="col-lg-12">
                    <h2 class="text-center mb-4">Our Mission</h2>
                    <p class="text-center">We are committed to providing accurate, real-time air quality data to help communities make informed decisions about their environment. Our platform combines advanced sensor technology with powerful data analytics to deliver comprehensive air quality monitoring solutions.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center mb-4">Key Features</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Real-time air quality monitoring</li>
                                <li class="list-group-item">Historical data analysis</li>
                                <li class="list-group-item">Customizable alerts and notifications</li>
                                <li class="list-group-item">Interactive data visualization</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Multi-sensor integration</li>
                                <li class="list-group-item">API access for developers</li>
                                <li class="list-group-item">Mobile-responsive design</li>
                                <li class="list-group-item">Exportable reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>
</html> 