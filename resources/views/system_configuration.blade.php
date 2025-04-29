<html>
<head>
<style>
    /* Sidebar & Layout Styles */
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
    .form-section {
        background: #fff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        max-width: 800px;
        margin: auto;
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
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
    }
    @media (max-width: 900px) {
        .main-content { padding: 24px 8px; }
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
    </nav>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;">
        @csrf
        <button type="submit" class="logout-btn">Log out</button>
    </form>
</div>

<div class="main-content">
    <div class="dashboard-header">
        System Configuration
    </div>

    <div class="form-section">
        <form method="POST" action="{{ route('system-configuration.store') }}">
            @csrf
            
            <h5>Database Settings</h5>
            <div class="mb-3">
                <label for="database_url" class="form-label">Database URL</label>
                <input type="text" class="form-control" id="database_url" name="database_url" 
                       value="{{ old('database_url', config('database.connections.mysql.host')) }}" required>
            </div>

            <h5>System Settings</h5>
            <div class="mb-3">
                <label for="timezone" class="form-label">Timezone</label>
                <select class="form-select" id="timezone" name="timezone" required>
                    @foreach(timezone_identifiers_list() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', config('app.timezone')) == $tz ? 'selected' : '' }}>
                            {{ $tz }}
                        </option>
                    @endforeach
                </select>
            </div>

            <h5>Map Settings</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="map_latitude" class="form-label">Map Center Latitude</label>
                        <input type="number" step="0.000001" class="form-control" id="map_latitude" 
                               name="map_latitude" value="{{ old('map_latitude', config('map.center.lat', 6.9271)) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="map_longitude" class="form-label">Map Center Longitude</label>
                        <input type="number" step="0.000001" class="form-control" id="map_longitude" 
                               name="map_longitude" value="{{ old('map_longitude', config('map.center.lng', 79.8612)) }}" required>
                    </div>
                </div>
            </div>

            <h5>Debug Settings</h5>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="debug_mode" name="debug_mode" 
                       {{ old('debug_mode', config('app.debug')) ? 'checked' : '' }}>
                <label class="form-check-label" for="debug_mode">Enable Debug Mode</label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any necessary JavaScript here
    });
</script>
</body>

</html>
