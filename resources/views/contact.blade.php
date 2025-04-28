<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - BreatheSafe Colombo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
       
        .navbar {
            margin-bottom: 20px;
            background-color: #87CEEB !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #2c3e50 !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: #1a2634 !important;
        }
        .nav-link.active {
            color: #1a2634 !important;
            font-weight: 600;
        }

        
        body {
            background: linear-gradient(to right, #e0f7ff, #f8fcff);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding-top: 80px;
        }

        .contact-container {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 700;
        }

        .form-control {
            background-color: #f7fbff;
            border: 2px solid #87CEEB;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 16px;
            color: #333;
        }

        .form-control:focus {
            border-color: #00aaff;
            box-shadow: 0 0 5px rgba(0,170,255,0.5);
        }

        .btn-sky {
            background-color: #87CEEB;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn-sky:hover {
            background-color: #00aaff;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>

<body>

<div id="app">
    
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <span class="brand-icon">*</span> BreatheSafe Colombo
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

    <div class="contact-container mt-5">
        <h2>Contact Us</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class="mb-3">
                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            </div>

            <div class="mb-3">
                <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-sky">Send Message</button>
            </div>
        </form>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
