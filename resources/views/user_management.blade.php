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
    <div class="page-header">User Management</div>
    
    <div class="user-actions">
        <button class="add-user-btn" onclick="openAddUserModal()">+ Add New User</button>
        <div class="search-box">
            <input type="text" placeholder="Search users..." id="userSearch" onkeyup="searchUsers()">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <table class="users-table">
        <thead>
            <tr>
                <th>Username</th>
                
                <th>Role</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                
                <td><span class="user-role">{{ $user->role }}</span></td>
                <td>{{ $user->status }}</td>
                <td>
                    <button class="action-btn" onclick="openEditUserModal({{ $user->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn" onclick="openResetPasswordModal({{ $user->id }})">
                        <i class="fas fa-key"></i>
                    </button>
                    <button class="action-btn delete" onclick="confirmDeleteUser({{ $user->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div class="modal" id="addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Add New User</h2>
            <button class="close-modal" onclick="closeModal('addUserModal')">&times;</button>
        </div>
        <form id="addUserForm" action="{{ route('create_user') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="MonitoringAdmin">MonitoringAdmin</option>
                    <option value="WebMaster">WebMaster</option>
                </select>
            
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal('addUserModal')">Cancel</button>
                <button type="submit" class="save-btn">Save User</button>
            </div>
        </form>
    </div>
</div>

<!-- You can also add EditUserModal and ResetPasswordModal similar to AddUserModal -->

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
        .user-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .add-user-btn {
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
        .add-user-btn:hover {
            background: #1a8ca7;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 24px;
            padding: 0 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .search-box input {
            border: none;
            outline: none;
            padding: 12px;
            width: 200px;
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .search-box i {
            color: #4bbfd6;
        }
        .users-table {
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border-collapse: collapse;
            overflow: hidden;
        }
        .users-table th {
            background: #eaf6fa;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #1a8ca7;
        }
        .users-table tr:not(:last-child) {
            border-bottom: 1px solid #f0f0f0;
        }
        .users-table td {
            padding: 16px;
        }
        .user-role {
            background: #d0f0fa;
            color: #1a8ca7;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #4bbfd6;
            margin-right: 8px;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .action-btn:hover {
            color: #1a8ca7;
        }
        .action-btn.delete {
            color: #ff6b6b;
        }
        .action-btn.delete:hover {
            color: #ff3e3e;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: #fff;
            border-radius: 16px;
            width: 500px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #222;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1rem;
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
        @media (max-width: 900px) {
            .main-content { 
                margin-left: 0;
                padding: 24px 16px; 
            }
            .sidebar {
                display: none;
            }
            .user-actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
            }
        }Paste your entire <style> CSS here */
    </style>
@endpush

@push('scripts')
<script>
function openAddUserModal() {
    document.getElementById('addUserModal').classList.add('show');
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}
function openEditUserModal(userId) {
    // You can load the user details via Ajax if you want
    document.getElementById('editUserModal').classList.add('show');
}
function openResetPasswordModal(userId) {
    document.getElementById('resetPasswordModal').classList.add('show');
}
function confirmDeleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Submit a delete request here
    }
}
function searchUsers() {
    let input = document.getElementById('userSearch').value.toLowerCase();
    let rows = document.querySelectorAll('#usersTableBody tr');
    rows.forEach(row => {
        let username = row.children[0].innerText.toLowerCase();
        let email = row.children[1].innerText.toLowerCase();
        if (username.includes(input) || email.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>
@endpush
