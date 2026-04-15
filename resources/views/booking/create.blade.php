<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking - Caroline Nail art</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-pink: #FF4D8D;
            --hover-pink: #E6457E;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            color: var(--primary-pink) !important;
            font-weight: 600;
        }
        
        .nav-link {
            color: #333 !important;
            margin: 0 10px;
        }
        
        .nav-link.active {
            color: var(--primary-pink) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-pink);
            border-color: var(--primary-pink);
        }
        
        .btn-primary:hover {
            background-color: var(--hover-pink);
            border-color: var(--hover-pink);
        }
        
        .btn-login {
            background-color: var(--primary-pink);
            color: white;
            border-radius: 20px;
            padding: 8px 25px;
        }
        
        .time-slot {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .time-slot:hover {
            border-color: var(--primary-pink);
            background-color: #fff5f8;
        }
        
        .time-slot.selected {
            background-color: var(--primary-pink);
            color: white;
            border-color: var(--primary-pink);
        }
        
        .calendar-day {
            padding: 8px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .calendar-day:hover {
            background-color: #f8f9fa;
        }
        
        .calendar-day.selected {
            background-color: var(--primary-pink);
            color: white;
        }
        
        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 30px;
        }
        
        .policy-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
        }
        
        
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-pink);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/img/logo.png" alt="Caroline Nail Art" style="height: 30px;" class="mb-3"><i>Caroline Nail Art</i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/collection">Collection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/booking">Booking</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="/cart" class="position-relative me-3">
                        <i class="bi bi-cart3" style="font-size: 1.5rem; color: #333;"></i>
                        <span class="cart-badge">0</span>
                    </a>
                    <a  href="/login" class="btn btn-loginl">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center section-title">Jadwalkan Waktu Anda</h2>

    <!-- React Root -->
    <div id="booking-root"></div>

    <!-- Booking Policy -->
    <div class="policy-box mt-4">
        <h4 class="mb-4">Kebijakan Pemesanan</h4>
        <ul class="list-unstyled">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Pembatalan atau perubahan jadwal harus dilakukan setidaknya 24 jam sebelum waktu janji temu yang dijadwalkan.</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Keterlambatan lebih dari 15 menit tanpa pemberitahuan dapat mengakibatkan pembatalan janji temu.</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Harga dapat bervariasi tergantung pada kompleksitas desain atau kebutuhan bahan tambahan.</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Untuk layanan nail art premium, disarankan untuk melakukan konsultasi awal.</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Kebijakan ini dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Dengan mengkonfirmasi pemesanan, Anda menyetujui semua ketentuan yang berlaku.</li>
        </ul>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="footer-logo mb-3">
                   <img src="/img/logo.png" alt="Caroline Nail Art" style="height: 30px;" class="mb-3"><i>Caroline Nail Art</i>
                </h5>
                <p class="text-muted">Your destination for exquisite nail artistry and premium products.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">Perusahaan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Tentang Kami</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Karir</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Blog</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Dukungan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Hubungi Kami</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Pengiriman & Pengembalian</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Hukum</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Kebijakan Privasi</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Ketentuan Layanan</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center text-muted py-3">
            <small>&copy; 2025 Rio Putra Anugrah . All rights reserved.</small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>