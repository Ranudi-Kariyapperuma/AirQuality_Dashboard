<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Air Quality Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Air Quality Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports') }}">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12 text-center">
                    <h1 class="display-4 mb-4">About Air Quality Dashboard</h1>
                    <p class="lead">Real-time air quality monitoring and analysis platform</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="bi bi-speedometer2 feature-icon"></i>
                        <h3>Real-time Monitoring</h3>
                        <p>Track air quality parameters in real-time with our advanced sensor network.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h3>Data Analysis</h3>
                        <p>Comprehensive analysis of air quality data with interactive visualizations.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="bi bi-bell feature-icon"></i>
                        <h3>Alert System</h3>
                        <p>Get instant notifications when air quality parameters exceed safe levels.</p>
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

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Air Quality Dashboard</h5>
                    <p>Providing real-time air quality monitoring solutions.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 Air Quality Dashboard. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>
</html> 