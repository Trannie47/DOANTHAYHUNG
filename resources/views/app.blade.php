<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'THIỆN TÂM MEDICAL')</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/img/logo.png') }}">

    <!-- Bootstrap 5 CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    {{-- Header & Footer CSS --}}
    @php
        $header = new \App\View\Components\Header();
        $header->prepare();
        $footer = new \App\View\Components\Footer();
        $footer->prepare();
        $footer = new \App\View\Components\ProductModal();
        $footer->prepare();
    @endphp
    
    {!! view()->shared('header_styles') ?? '' !!}
    {!! view()->shared('footer_styles') ?? '' !!}
    {!! view()->shared('product_modal_styles') ?? '' !!}
    {{-- CSS riêng từng trang --}}
    @stack('styles')

    {{-- FLASH MESSAGE CSS --}}
    <style>
        .alert {
            padding: 12px 20px;
            border-radius: 6px;
            position: fixed;
            top: 80px; 
            right: 20px;
            z-index: 9999;
            color: #fff;
            font-weight: bold;
            animation: fadeIn 0.3s ease-out;
        }
        .alert-success { background: #28a745; }
        .alert-error { background: #dc3545; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    {{-- Header component --}}
    {!! $header->html() !!}

    {{-- FLASH MESSAGE - Đặt ngay dưới header --}}
    @if (session('success'))
        <div class="alert alert-success" id="alert-box">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error" id="alert-box">
            {{ session('error') }}
        </div>
    @endif

    {{-- Nội dung từng trang --}}
    @yield('content')

    {{-- Product Modal component --}}
    <x-product-modal />

    {{-- Footer component --}}
    <x-footer />

    <!-- Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Bootstrap 5 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
        
    {{-- Header & Footer JS --}}
    {!! view()->shared('header_scripts') ?? '' !!}
    {!! view()->shared('footer_scripts') ?? '' !!}
    {!! view()->shared('product_modal_scripts') ?? '' !!}
    {{-- JS riêng từng trang --}}
    @stack('scripts')

    {{-- Flash message auto-hide --}}
    <script>
        setTimeout(() => {
            const alert = document.getElementById('alert-box');
            if (alert) {
                alert.style.transition = '0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>

</body>
</html>
