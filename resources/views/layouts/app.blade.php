<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'TK Puspitasari Kaliwatubumi — Website Resmi TK Puspitasari')</title>
    <meta name="description"
        content="@yield('meta_description', 'Website resmi TK Puspitasari Kaliwatubumi. Sekolah Taman Kanak-Kanak yang berlandaskan nilai Islami, kreatif, dan berdedikasi dalam mengembangkan potensi anak usia dini.')">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
    @yield('styles')

    <style>
        :root {
            --color-primary: #4CAF93;
            --color-primary-dark: #3a9478;
            --color-primary-light: #e8f5f1;
            --color-accent: #f9a825;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333333;
            background-color: #ffffff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* ==================== NAVBAR TOP ==================== */
        .navbar-top {
            background-color: #fff;
            border-bottom: 1px solid #eeeeee;
            padding: 8px 0;
        }

        .navbar-top-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-logo {
            height: 90px;
            object-fit: contain;
        }

        .header-top-info {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .header-top-contact {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-contact-item .bi {
            font-size: 20px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary);
            color: #fff;
            border-radius: 50%;
        }

        .header-top-phone-info h5 {
            font-size: 12px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .header-top-phone-info p {
            font-size: 13px;
            margin: 0;
            color: #333;
        }

        .header-contact {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-contact a {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary-light);
            color: var(--color-primary);
            border-radius: 50%;
            font-size: 16px;
            transition: all 0.2s;
        }

        .header-contact a:hover {
            background-color: var(--color-primary);
            color: #fff;
        }

        /* ==================== NAVBAR MAIN ==================== */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand .navbar-logo {
            height: 50px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 4px;
        }

        .navbar-nav .nav-item {
            position: relative;
        }

        .navbar-nav .nav-link {
            display: block;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
            white-space: nowrap;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--color-primary);
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            box-shadow: 0 8px 24 rgba(0, 0, 0, 0.12);
            min-width: 220px;
            padding: 8px 0;
            z-index: 999;
            list-style: none;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 8px 20px;
            font-size: 13px;
            color: #444;
            transition: background 0.15s, color 0.15s;
        }

        .dropdown-item:hover {
            background-color: var(--color-primary-light);
            color: var(--color-primary);
        }

        .dropdown-toggle::after {
            content: '\F282';
            font-family: 'bootstrap-icons';
            font-size: 11px;
            margin-left: 4px;
        }

        /* PSB Button */
        .btn-primary {
            background-color: var(--color-primary);
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        /* Mobile hamburger */
        .navbar-toggler {
            display: none;
            background: none;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            color: #333;
        }

        /* ===== MOBILE COLLAPSE MENU ===== */
        .mobile-menu {
            display: none;
            background: #fff;
            border-top: 1px solid #eee;
        }

        .mobile-menu.open {
            display: block;
        }

        /* Perbaikan: Paksa menu turun ke bawah di HP */
        .mobile-menu .navbar-nav {
            flex-direction: column;
            align-items: stretch;
            gap: 0;
        }

        /* Semua nav-link di dalam mobile-menu */
        .mobile-menu .nav-link {
            display: block;
            padding: 12px 20px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .mobile-menu .nav-link:hover {
            color: var(--color-primary);
        }

        /* Dropdown di dalam mobile menu */
        .mobile-menu .nav-item.dropdown .dropdown-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu .dropdown-menu {
            position: static;
            display: none;
            box-shadow: none;
            border: none;
            border-radius: 0;
            padding: 0;
            background: #f8fdfb;
        }

        .mobile-menu .dropdown-menu.show {
            display: block;
        }

        .mobile-menu .dropdown-item {
            padding: 10px 20px 10px 36px;
            font-size: 13px;
            border-bottom: 1px solid #eef8f5;
            color: #555;
        }

        .mobile-menu .dropdown-item:hover {
            background-color: var(--color-primary-light);
            color: var(--color-primary);
        }

        /* Chevron icon dropdown toggle di mobile */
        .mobile-menu .dropdown-toggle::after {
            content: '\F282';
            font-family: 'bootstrap-icons';
            font-size: 12px;
            margin-left: auto;
        }

        .mobile-menu .dropdown-toggle.active-toggle::after {
            content: '\F286';
        }

        /* PSB button di dalam mobile menu - Update Link */
        .mobile-menu .btn-psb-mobile {
            display: block;
            margin: 16px 20px;
            text-align: center;
            background-color: var(--color-primary);
            color: #fff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .mobile-menu .btn-psb-mobile:hover {
            background-color: var(--color-primary-dark);
            color: #fff;
        }

        /* ==================== CONTAINER ==================== */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ==================== FOOTER ==================== */
        .footer {}

        .footer-top {
            background-color: #1a2332;
            padding: 60px 0 40px;
            color: #fff;
        }

        .footer-top .widgettitle {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-primary);
            display: inline-block;
        }

        .footer-top p,
        .footer-top .textwidget,
        .footer-top ul {
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
        }

        .footer-top a {
            color: rgba(255, 255, 255, 0.75);
            transition: color 0.2s;
        }

        .footer-top a:hover {
            color: var(--color-primary);
        }

        .footer-top ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-top ul li {
            margin-bottom: 8px;
        }

        .footer-top ul li a::before {
            content: '› ';
            color: var(--color-primary);
        }

        .footer-logo {
            height: 80px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .footer-tagline {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            margin: 8px 0 20px;
            font-style: italic;
        }

        .footer-social-media {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .footer-social-media a {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            transition: background 0.2s;
        }

        .footer-social-media a:hover {
            background: var(--color-primary);
            color: #fff;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
        }

        .footer-bottom {
            background-color: #eef2f7;
            padding: 14px 0;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 992px) {
            .navbar-top {
                display: none;
            }

            #main-nav-links {
                display: none;
            }

            .navbar-toggler {
                display: block;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ==================== SECTION SHARED STYLES ==================== */
        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px;
            color: #222;
        }

        .section-header p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .slider-section-nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-slider-nav {
            display: flex;
            gap: 6px;
            color: var(--color-primary);
            font-size: 24px;
        }

        .section-slider-nav div {
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .section-slider-nav div:hover {
            opacity: 0.7;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- ===================== NAVBAR TOP (Desktop) ===================== -->
    <div class="navbar-top d-lg-block">
        <div class="container">
            <div class="navbar-top-wrapper">
                <a class="navbar-brand" href="/">
                    <img class="navbar-logo" src="{{ asset('images/logo.png') }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        alt="Logo TK Puspitasari">
                    <div style="display:none; align-items:center; gap:8px;">
                        <div
                            style="width:50px; height:50px; background:linear-gradient(135deg,#4CAF93,#3a9478); border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:18px;">
                            TK</div>
                        <div>
                            <div style="font-weight:800; font-size:18px; color:#1a2332;">Puspitasari</div>
                            <div style="font-size:11px; color:#666;">Kaliwatubumi</div>
                        </div>
                    </div>
                </a>

                <div class="header-top-info">
                    <div class="header-top-contact">
                        <div class="header-contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div class="header-top-phone-info">
                                <h5>Alamat</h5>
                                <p>Kaliwatubumi, Butuh, Purworejo</p>
                            </div>
                        </div>
                        <div class="header-contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <div class="header-top-phone-info">
                                <h5>Hubungi Kami</h5>
                                <p>0853-2820-9910</p>
                            </div>
                        </div>
                    </div>

                    <div class="header-contact">
                        <a target="_blank" href="https://wa.me/6285328209910" title="WhatsApp"><i
                                class="bi bi-whatsapp"></i></a>
                        <a target="_blank" href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a target="_blank" href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== NAVBAR MAIN ===================== -->
    <nav class="navbar" id="main-navbar">
        <div class="container">
            <div class="navbar-inner">
                <!-- Logo mobile (Sudah diperbaiki ke logo.png) -->
                <a class="navbar-brand" href="/" style="display:none;" id="navbar-mobile-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo TK Puspitasari"
                        style="height: 50px; object-fit: contain;">
                </a>

                <!-- Navigation links -->
                <ul class="navbar-nav" id="main-nav-links">
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">Profil Kami</a>
                        <ul class="dropdown-menu">
                            <li><a href="/profil-sekolah" class="dropdown-item">Profil Sekolah</a></li>
                            <li><a href="/identitas-sekolah" class="dropdown-item">Identitas Sekolah</a></li>
                            <li><a href="/visi-misi" class="dropdown-item">Visi &amp; Misi</a></li>
                            <li><a href="/#program" class="dropdown-item">Staf Pengajar</a></li>
                            <li><a href="/#fasilitas" class="dropdown-item">Fasilitas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">Informasi</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('berita.index') }}" class="dropdown-item">Laman Berita</a></li>
                            <li><a href="{{ url('/agenda') }}" class="dropdown-item">Agenda Sekolah</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- PSB Button - Update Link -->
                <a href="{{ url('/portal/ppdb') }}" class="btn btn-primary" style="display:none;" id="navbar-psb-btn">
                    PSB {{ date('Y') }}/{{ date('Y') + 1 }}
                </a>

                <!-- Hamburger -->
                <button class="navbar-toggler" id="hamburger-btn" aria-label="Toggle navigation">
                    <i class="bi bi-list" style="font-size:24px;"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu (Bootstrap-style collapse with dropdowns) -->
        <div class="mobile-menu" id="mobile-menu">
            <ul class="navbar-nav" style="list-style:none; margin:0; padding:0;">
                <!-- Beranda -->
                <li class="nav-item">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                </li>

                <!-- Profil Kami - Dropdown -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="mobile-dropdown-profil" role="button">
                        Profil Kami
                    </a>
                    <ul class="dropdown-menu" id="mobile-submenu-profil">
                        <li><a class="dropdown-item" href="/profil-sekolah">Profil Sekolah</a></li>
                        <li><a class="dropdown-item" href="/identitas-sekolah">Identitas Sekolah</a></li>
                        <li><a class="dropdown-item" href="/visi-misi">Visi &amp; Misi</a></li>
                        <li><a class="dropdown-item" href="/#program">Staf Pengajar</a></li>
                        <li><a class="dropdown-item" href="/#fasilitas">Fasilitas</a></li>
                    </ul>
                </li>

                <!-- Informasi - Dropdown -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="mobile-dropdown-informasi" role="button">
                        Informasi
                    </a>
                    <ul class="dropdown-menu" id="mobile-submenu-informasi">
                        <li><a class="dropdown-item" href="{{ route('berita.index') }}">Laman Berita</a></li>
                        <li><a class="dropdown-item" href="{{ url('/agenda') }}">Agenda Sekolah</a></li>
                    </ul>
                </li>
            </ul>

            <!-- PSB Button - Update Link -->
            <a href="{{ url('/portal/ppdb') }}" class="btn-psb-mobile">
                PSB {{ date('Y') }}/{{ date('Y') + 1 }}
            </a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- ===================== FOOTER ===================== -->
    <footer class="footer" id="kontak">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <!-- Column 1: Logo & Sosmed -->
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo TK Puspitasari" class="footer-logo">
                        <p class="footer-tagline">"Cerdas, Taqwa, Kreatif"</p>
                        <p style="font-size:13px; color:rgba(255,255,255,0.65); line-height:1.7;">
                            TK Puspitasari Kaliwatubumi hadir untuk mendidik anak usia dini dengan landasan nilai Islami
                            yang kuat, metode pembelajaran kreatif, dan lingkungan yang penuh kasih sayang.
                        </p>

                        <h2 class="widgettitle" style="margin-top:20px;">Sosial Media</h2>
                        <div class="footer-social-media">
                            <a target="_blank" href="https://wa.me/6285328209910" title="WhatsApp"><i
                                    class="bi bi-whatsapp"></i></a>
                            <a target="_blank" href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                            <a target="_blank" href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>

                    <!-- Column 2: Profil Sekolah -->
                    <div>
                        <h2 class="widgettitle">Profil Sekolah</h2>
                        <ul>
                            <li><a href="#profil">Profil Sekolah</a></li>
                            <li><a href="#guru">Staf Pengajar</a></li>
                            <li><a href="#fasilitas">Fasilitas</a></li>
                            <li><a href="{{ url('/agenda') }}">Agenda</a></li>
                            <li><a href="#berita">Informasi & Berita</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Info Kontak -->
                    <div>
                        <h2 class="widgettitle">Hubungi Kami</h2>
                        <ul style="list-style:none; padding:0;">
                            <li style="margin-bottom:12px; display:flex; gap:8px; align-items:flex-start;">
                                <i class="bi bi-geo-alt-fill" style="color:var(--color-primary); margin-top:3px;"></i>
                                <span style="color:rgba(255,255,255,0.75); font-size:14px;">Kaliwatubumi, Butuh,
                                    Purworejo</span>
                            </li>
                            <li style="margin-bottom:12px; display:flex; gap:8px; align-items:center;">
                                <i class="bi bi-telephone-fill" style="color:var(--color-primary);"></i>
                                <span style="color:rgba(255,255,255,0.75); font-size:14px;">0853-2820-9910 (Ibu
                                    Kotijah)</span>
                            </li>
                            <li style="margin-bottom:12px; display:flex; gap:8px; align-items:center;">
                                <i class="bi bi-telephone-fill" style="color:var(--color-primary);"></i>
                                <span style="color:rgba(255,255,255,0.75); font-size:14px;">0823-1247-4292 (Ibu
                                    Sukowati)</span>
                            </li>
                        </ul>

                        <h2 class="widgettitle" style="margin-top:16px;">Link Penting</h2>
                        <ul>
                            <!-- Update Link -->
                            <li><a href="{{ url('/portal/ppdb') }}">PSB {{ date('Y') }}/{{ date('Y') + 1 }}</a></li>
                            <li><a href="/admin">Admin Panel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p style="margin:0;">{{ date('Y') }} &copy; TK Puspitasari Kaliwatubumi. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // ===== Hamburger Toggle =====
        document.getElementById('hamburger-btn').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        });

        // ===== Mobile Dropdown Accordion =====
        document.querySelectorAll('.mobile-menu .dropdown-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parentLi = this.closest('.nav-item.dropdown');
                const submenu = parentLi.querySelector('.dropdown-menu');
                const isOpen = submenu.classList.contains('show');

                // Tutup semua submenu lain terlebih dahulu
                document.querySelectorAll('.mobile-menu .dropdown-menu.show').forEach(function (openMenu) {
                    openMenu.classList.remove('show');
                });
                document.querySelectorAll('.mobile-menu .dropdown-toggle.active-toggle').forEach(function (activeToggle) {
                    activeToggle.classList.remove('active-toggle');
                });

                // Toggle submenu yang diklik
                if (!isOpen) {
                    submenu.classList.add('show');
                    this.classList.add('active-toggle');
                }
            });
        });

        // ===== Show/hide elements based on screen width =====
        function checkWidth() {
            const w = window.innerWidth;
            const mobileBrand = document.getElementById('navbar-mobile-brand');
            const psbBtn = document.getElementById('navbar-psb-btn');
            const navLinks = document.getElementById('main-nav-links');

            if (w < 993) {
                if (mobileBrand) mobileBrand.style.display = 'flex';
                if (psbBtn) psbBtn.style.display = 'none';
                if (navLinks) navLinks.style.display = 'none';
            } else {
                if (mobileBrand) mobileBrand.style.display = 'none';
                if (psbBtn) psbBtn.style.display = 'inline-block';
                if (navLinks) navLinks.style.display = 'flex';
                // Tutup mobile menu jika kembali ke desktop
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) mobileMenu.classList.remove('open');
            }
        }

        checkWidth();
        window.addEventListener('resize', checkWidth);
    </script>

    @livewireScripts
    @yield('scripts')
</body>

</html>