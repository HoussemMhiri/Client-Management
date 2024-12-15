<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #3730a3;
        --text-light: #f8fafc;
        --sidebar-width: 280px;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Inter', sans-serif;
        margin: 0;
    }

    /* Navbar Styles */
    .navbar {
        background-color: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem;
    }

    .navbar-brand {
        color: var(--primary-color) !important;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #64748b !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-color) !important;
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        height: calc(100vh - 70px);
        width: var(--sidebar-width);
        background: white;
        border-right: 1px solid #e2e8f0;
        padding: 2rem 1.5rem;
        overflow-y: auto; /* Enables scrolling if content overflows */
    }

    .sidebar h4 {
        color: #1e293b;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .sidebar .nav-item {
        margin-bottom: 0.5rem;
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: #64748b !important;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link i {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }

    .sidebar .nav-link:hover {
        background-color: #f1f5f9;
        color: var(--primary-color) !important;
    }

    .sidebar .nav-link.active {
        background-color: var(--primary-color);
        color: white !important;
    }

    /* Main Content */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-top: 70px; /* Prevent overlap with navbar */
        padding: 2rem;
      /*   text-align: center; */ /* Center-align content */
        width: calc(100% - var(--sidebar-width));
    }

    .main-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
    }

    .main-content p.lead {
        color: #64748b;
    }

    /* Custom Button */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-1px);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<!-- HTML Structure -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <i class="fas fa-chart-line me-2"></i>
            Dashboard
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-primary"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fas fa-home me-1"></i> Home</a>
                </li>
                <li class="nav-item ms-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-user me-1"></i> Profile
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="d-flex">
    <div class="sidebar">
        <h4>Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('clients.index') }}">
                    <i class="fas fa-users"></i>
                    Clients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-file-invoice"></i>
                    Invoices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if (request()->is('/'))
        <div style="text-align: center">
            <h1>Dashboard</h1>
            <p class="lead">Welcome to the administrative dashboard. Manage your clients, invoices, and settings here.</p>
        </div>
          

            <!-- Display the Dashboard Summary Component -->
            <x-dashboard.dashboard-summary />
        @else
            @yield('content')
        @endif
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<!-- Bootstrap JS (Bootstrap Bundle includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

@yield('scripts')

</body>
</html>
