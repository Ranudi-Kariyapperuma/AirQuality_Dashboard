<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
        }
        .dashboard-cards {
            display: flex;
            gap: 32px;
            margin-bottom: 40px;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 32px 40px;
            min-width: 200px;
            flex: 1;
            text-align: center;
        }
        .dashboard-card h3 {
            font-size: 1.1rem;
            color: #4bbfd6;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .dashboard-card .card-value {
            font-size: 2.2rem;
            font-weight: 700;
        }
        .recent-alerts {
            margin-bottom: 32px;
        }
        .recent-alerts h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .alert-list {
            list-style: none;
            padding: 0;
            margin: 0 0 18px 0;
        }
        .alert-item {
            display: flex;
            align-items: center;
            background: #eaf6fa;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 12px;
        }
        .alert-icon {
            color: #f7b731;
            font-size: 1.5rem;
            margin-right: 18px;
        }
        .alert-content {
            flex: 1;
        }
        .alert-time {
            color: #4bbfd6;
            font-size: 0.95rem;
            margin-left: 18px;
            min-width: 70px;
            text-align: right;
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

        .new-sensor-btn {
            background: #4bbfd6;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .new-sensor-btn:hover {
            background: #1a8ca7;
        }
        @media (max-width: 900px) {
            .main-content { padding: 24px 8px; }
            .dashboard-cards { flex-direction: column; gap: 18px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

            <a href="{{ route('alert-configuration') }}" class="{{ request()->routeIs('alert-configuration') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Alert Configuration
            </a>
        
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
    </div>
    <div class="main-content">
        <div class="dashboard-header">Dashboard</div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>Total Sensors</h3>
                <div class="card-value">{{ $totalSensors }}</div>
            </div>
            <div class="dashboard-card">
                <h3>Active Sensors</h3>
                <div class="card-value">{{ $activeSensors }}</div>
            </div>
            <div class="dashboard-card">
                <h3>Simulation Status</h3>
                <div class="card-value">{{ $simulationStatus }}</div>
            </div>
            <div class="dashboard-card">
                <h3>Alerts Today</h3>
                <div class="card-value">{{ $alertsToday }}</div>
            </div>
        </div>
        <div class="recent-alerts">
            <h2>Recent Alerts</h2>
            <ul class="alert-list">
                @foreach($recentAlerts as $alert)
                <li class="alert-item">
                    <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="alert-content">
                        <div>{{ $alert['message'] }}</div>
                        <a href="{{ $alert['link'] }}" style="color:#4bbfd6; font-size:0.98rem;">Details</a>
                    </div>
                    <div class="alert-time">{{ $alert['time'] }}</div>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('sensors.create') }}" class="new-sensor-btn">+ New Sensor</a>
        </div>
    </div>
</body>
</html>
