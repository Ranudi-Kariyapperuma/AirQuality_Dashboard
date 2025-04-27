@extends('layouts.app')

@section('content')
<div class="sidebar">
    <div class="user-info">
        <h4>Admin Dashboard</h4>
        <span class="role">Administrator</span>
    </div>
    <nav>
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('alert-configuration') }}">
            <i class="fas fa-bell"></i> Alert Configuration
        </a>
        <a href="{{ route('system-configuration') }}">
            <i class="fas fa-cog"></i> System Configuration
        </a>
        <a href="{{ route('admin.users') }}" class="active">
            <i class="fas fa-users"></i> User Management
        </a>
        <a href="{{ route('admin.reports') }}">
            <i class="fas fa-chart-bar"></i> Reports
        </a>
    </nav>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;">
        @csrf
        <button type="submit" class="logout-btn">Log out</button>
    </form>
</div>

<div class="main-content">
    <div class="page-header">Edit User</div>
    
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>User Information</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-input @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-input @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current password">
                    <small class="form-helper">Leave blank if you don't want to change the password.</small>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-input @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.users') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="save-btn">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
        .page-header {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 32px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .card-header {
            background: #eaf6fa;
            padding: 20px 24px;
            border-bottom: 1px solid #d0f0fa;
        }
        .card-header h3 {
            margin: 0;
            color: #1a8ca7;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .card-body {
            padding: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #222;
        }
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #4bbfd6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(75, 191, 214, 0.2);
        }
        .form-input.is-invalid {
            border-color: #ff6b6b;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .form-helper {
            color: #666;
            font-size: 0.9rem;
            display: block;
            margin-top: 5px;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 24px;
        }
        .cancel-btn {
            background: #f0f0f0;
            color: #222;
            border: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .cancel-btn:hover {
            background: #e0e0e0;
        }
        .save-btn {
            background: #4bbfd6;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .save-btn:hover {
            background: #1a8ca7;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 900px) {
            .main-content { 
                margin-left: 0;
                padding: 24px 16px; 
            }
            .sidebar {
                display: none;
            }
        }
    </style>
@endpush