<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
        }
        .sidebar .nav-link {
            color: #6b7280;
            font-weight: 500;
        }
        .sidebar .nav-link.active {
            background: #f1f5f9;
            color: #0d6efd;
            border-radius: 8px;
        }
        .card-stat {
            border-radius: 12px;
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    <aside class="sidebar p-3">
        <h5 class="text-center fw-bold mb-4">Admin Panel</h5>

        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard.index') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}"
                 class="nav-link">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('admin.collections.index') }}"
                   class="nav-link {{ request()->routeIs('admin.collections*') ? 'active' : '' }}">
                    <i class="bi bi-collection me-2"></i> Collections
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                    <i class="bi bi-calendar-event me-2"></i> Kelola bookings
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="bi bi-cart me-2"></i> Kelola Pesanan Toko
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link">
                    <i class="bi bi-bar-chart me-2"></i> Reports
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-quote me-2"></i> Testimoni
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.chats.index') }}" class="nav-link {{ request()->routeIs('admin.chats*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots me-2"></i> Konsultasi (Chat)
                </a>
            </li>

            <li class="nav-item mt-3">
                <a href="{{ route('logout') }}"
                   class="nav-link text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column min-vh-100">

        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white border-bottom px-4">
            <span class="fw-semibold">
                Caroline Nail Art
            </span>

            <div class="d-flex align-items-center gap-2">
                <span class="fw-medium">{{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                     class="rounded-circle" width="36">
            </div>
        </nav>

        <!-- Page Content -->
        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center py-4 text-muted border-top bg-white mt-auto">
            © {{ date('Y') }} Caroline Nail Art Admin
        </footer>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
