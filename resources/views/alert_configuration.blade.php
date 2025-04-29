@extends('layouts.app')
@section('title', 'Alert Configuration')
@section('content')
<div class="container">
    <h2>Alert Thresholds</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('alert-configuration.store') }}">
        @csrf
        <input type="text" name="level" placeholder="Level (e.g., Moderate)" required>
        <input type="number" name="min_aqi" placeholder="Min AQI" required>
        <input type="number" name="max_aqi" placeholder="Max AQI" required>
        <input type="text" name="message" placeholder="Alert Message" required>
        <button type="submit">Add Threshold</button>
    </form>

    <table border="1" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Level</th>
                <th>Min AQI</th>
                <th>Max AQI</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alerts as $alert)
            <tr>
                <td>{{ $alert->level }}</td>
                <td>{{ $alert->min_aqi }}</td>
                <td>{{ $alert->max_aqi }}</td>
                <td>{{ $alert->message }}</td>
                <td>
                    <form method="POST" action="{{ route('alert-configuration.destroy', $alert->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
