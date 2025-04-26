<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Sensor - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .form-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 32px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-header {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #1a8ca7;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #4bbfd6;
            outline: none;
        }
        .submit-btn {
            background: #4bbfd6;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .submit-btn:hover {
            background: #1a8ca7;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #4bbfd6;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            color: #1a8ca7;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="user-info">
            <div style="font-weight:700; font-size:1.2rem;">{{ session('username') }}</div>
            <div class="role">Administrator</div>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="#" class="active"><i class="fas fa-microchip"></i> Sensors</a>
            <a href="#"><i class="fas fa-bell"></i> Alerts</a>
            <a href="#"><i class="fas fa-users"></i> Users</a>
            <a href="#"><i class="fas fa-cog"></i> Settings</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
    </div>
    <div class="main-content">
        <div class="form-container">
            <h1 class="form-header">Add New Sensor</h1>
            <form method="POST" action="{{ route('sensors.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Sensor Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="sensor_id">Sensor ID</label>
                    <input type="text" id="sensor_id" name="sensor_id" required placeholder="e.g., COL001">
                </div>
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="number" id="latitude" name="latitude" step="0.000001" required>
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="number" id="longitude" name="longitude" step="0.000001" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="is_active" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Add Sensor</button>
            </form>
            <a href="{{ route('admin.dashboard') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html> 