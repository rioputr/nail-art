<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caroline Nail Art - @yield('title', 'Seni Kuku')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <style>
        .btn-primary-custom {
            background-color: #E91E63; /* Warna Utama */
            border-color: #E91E63;
            color: white;
            padding: 10px 25px;
            font-weight: bold;
        }
        .btn-primary-custom:hover {
            background-color: #d81b60; /* Sedikit lebih gelap */
            border-color: #d81b60;
        }
        .text-primary-custom {
            color: #E91E63 !important;
        }
        .footer {
            background-color: #f8f9fa; /* Warna latar belakang footer */
        }
        .nav-link.active-custom {
            border-bottom: 2px solid #E91E63;
        }
        /* Style untuk section "Siap Untuk Transformasi Kuku Anda?" */
        .promo-section {
            background-color: #F8BBD0; /* Warna Sekunder */
            padding: 50px 0;
            margin-top: 50px;
            margin-bottom: 50px;
        }

    </style> -->
    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .whatsapp-float:hover {
            color: #FFF;
            background-color: #20b858;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tombol WhatsApp Mengambang -->
    <a href="https://wa.me/6281320497631?text=Halo%2c%20saya%20ingin%20konsultasi%20mengenai%20booking%20dan%20treatment%20nya" class="whatsapp-float" target="_blank" title="Hubungi Kami di WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
</body>
</html>