@extends('layouts.app')

@section('title', 'System Configuration')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>System Configuration</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('system-configuration.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <h5>Database Settings</h5>
                            <div class="mb-3">
                                <label for="database_url" class="form-label">Database URL</label>
                                <input type="text" class="form-control" id="database_url" name="database_url" 
                                       value="{{ old('database_url', config('database.connections.mysql.host')) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
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
                        </div>

                        <div class="mb-4">
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
                        </div>

                        <div class="mb-4">
                            <h5>Debug Settings</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="debug_mode" name="debug_mode" 
                                       {{ old('debug_mode', config('app.debug')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="debug_mode">Enable Debug Mode</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    h5 {
        color: #495057;
        margin-bottom: 1rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any necessary JavaScript here
});
</script>
@endsection 