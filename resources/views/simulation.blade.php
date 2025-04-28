<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simulation Control</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f4fbfd;
            color: #222;
        }
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 260px;
            background: #eaf6fa;
            padding: 32px 0 0 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .sidebar .user-info {
            margin-bottom: 32px;
            text-align: center;
        }
        .sidebar .user-info .role {
            color: #4bbfd6;
            font-size: 0.95rem;
        }
        .sidebar nav {
            width: 100%;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            padding: 14px 32px;
            color: #222;
            text-decoration: none;
            font-weight: 500;
            border-radius: 24px 0 0 24px;
            margin-bottom: 8px;
            transition: background 0.2s;
        }
        .sidebar nav a.active, .sidebar nav a:hover {
            background: #d0f0fa;
            color: #1a8ca7;
        }
        .sidebar nav a i {
            margin-right: 16px;
            font-size: 1.2rem;
        }
        .sidebar .logout-btn {
            margin-top: auto;
            margin-bottom: 32px;
            width: 80%;
            padding: 12px 0;
            background: #4bbfd6;
            color: #fff;
            border: none;
            border-radius: 24px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .sidebar .logout-btn:hover {
            background: #1a8ca7;
        }
        .main-content {
            margin-left: 260px;
            padding: 40px 48px;
        }
        .dashboard-header {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 32px;
            text-align: center;
            
        }

        .logout-btn {
          display: block;
          margin: 0 auto;
          padding: 10px 20px;
          font-size: 1rem;
          background-color: #f04e4e;
          color: white;
          border: none;
          border-radius: 8px;
          cursor: pointer;
         }
         
        .form-section {
            background: #fff;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            max-width: 600px;
            margin: auto;
        }
        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            
        }
        .form-section input, .form-section select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .form-section button {
            background: #4bbfd6;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .form-section button:hover {
            background: #1a8ca7;
        }
        .status-display {
            margin-top: 24px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #4bbfd6;
        }
        @media (max-width: 900px) {
            .main-content { padding: 24px 8px; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="user-info">
        <h4>Admin Dashboard</h4>
        <span class="role">Administrator</span>
    </div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    
        <a href="{{ route('system-configuration') }}" class="{{ request()->routeIs('system-configuration') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> System Configuration
        </a>
        <a href="{{ route('simulation.index') }}" class="{{ request()->routeIs('simulation.index') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i> Simulation Control
        </a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> User Management
        </a>
    </nav>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;">
        @csrf
        <button type="submit" class="logout-btn">Log out</button>
    </form>
</div>

<div class="main-content">
    <div class="dashboard-header">Simulation Control</div>

    <div class="form-section">
    <form action="{{ route('simulation.update') }}" method="POST">
        @csrf
         @method('PUT') 

            <label for="frequency">Frequency (minutes)</label>
            <input type="number" name="frequency" id="frequency" min="1" value="{{ $simulation->frequency ?? 5 }}" required>

            <label for="aqi_min">AQI Minimum</label>
            <input type="number" name="aqi_min" id="aqi_min" min="0" value="{{ $simulation->aqi_min ?? 0 }}" required>

            <label for="aqi_max">AQI Maximum</label>
            <input type="number" name="aqi_max" id="aqi_max" min="0" value="{{ $simulation->aqi_max ?? 500 }}" required>

            <label for="pattern_variation">Pattern Variation (%)</label>
            <input type="range" name="pattern_variation" id="pattern_variation" min="0" max="100" value="{{ $simulation->pattern_variation ?? 0 }}">

            <button type="submit">Update Simulation Settings</button>
        </form>

        <div class="status-display">
            Status: {{ $simulation->is_running ? 'Running' : 'Stopped' }} 
            @if($simulation->is_running)
                | Every {{ $simulation->frequency }} minutes
            @endif
        </div>

        <form method="POST" action="{{ route('simulation.toggle') }}" style="margin-top: 24px;">
            @csrf
            <button type="submit">{{ $simulation->is_running ? 'Stop Simulation' : 'Start Simulation' }}</button>
        </form>
    </div>
</div>

</body>
</html>
