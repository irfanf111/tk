@extends('layouts.app')

@section('title', ($visionMission->title ?? 'Visi & Misi') . ' — TK Puspitasari Kaliwatubumi')

@section('styles')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header-banner {
        background-color: #4CAF93;
        padding: 40px 0;
    }

    .page-header-banner h1 {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 6px;
    }

    .page-header-banner .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.85);
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    .page-header-banner .breadcrumb a {
        color: rgba(255, 255, 255, 0.85);
        transition: color 0.2s;
    }

    .page-header-banner .breadcrumb a:hover {
        color: #fff;
    }

    .page-header-banner .breadcrumb .active {
        color: #fff;
        font-weight: 600;
    }

    /* ===== PAGE BODY ===== */
    .page-body {
        background-color: #f8f9fa;
        padding: 40px 0;
    }

    /* ===== ARTICLE CARD ===== */
    .article-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .article-card .feature-image {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .article-card .article-body {
        padding: 24px;
    }

    .article-card .article-title {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    /* ===== PROSE (Rich Content) ===== */
    .prose h1 { font-size: 1.875rem; font-weight: 700; color: #111827; margin: 1.5rem 0 0.75rem; }
    .prose h2 { font-size: 1.4rem; font-weight: 700; color: #1f2937; margin: 1.5rem 0 0.5rem; border-bottom: 2px solid #4CAF93; padding-bottom: 6px; }
    .prose h3 { font-size: 1.15rem; font-weight: 600; color: #374151; margin: 1.25rem 0 0.5rem; }
    .prose p { color: #374151; line-height: 1.75; margin-bottom: 1rem; }
    .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; color: #374151; }
    .prose ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; color: #374151; }
    .prose li { margin-bottom: 0.375rem; line-height: 1.7; }
    .prose strong { font-weight: 700; color: #111827; }
    .prose em { font-style: italic; }
    .prose a { color: #4CAF93; text-decoration: underline; }
    .prose a:hover { color: #2d6a4f; }
    .prose blockquote { border-left: 4px solid #4CAF93; padding-left: 1rem; font-style: italic; color: #6b7280; margin: 1rem 0; }
    .prose img { max-width: 100%; height: auto; border-radius: 8px; margin: 1rem 0; }
    .prose table { width: 100%; border-collapse: collapse; margin: 1rem 0; font-size: 0.875rem; }
    .prose th { background: #f9fafb; font-weight: 600; text-align: left; padding: 0.5rem 0.75rem; border: 1px solid #e5e7eb; }
    .prose td { padding: 0.5rem 0.75rem; border: 1px solid #e5e7eb; }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state .icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #E8F5F1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-state .icon-wrap .bi {
        font-size: 32px;
        color: #4CAF93;
    }

    .empty-state p.lead {
        font-size: 15px;
        font-weight: 600;
        color: #555;
        margin-bottom: 4px;
    }

    .empty-state p.sub {
        font-size: 13px;
        color: #999;
        margin-bottom: 20px;
    }

    .btn-add-content {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border-radius: 50px;
        background-color: #4CAF93;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        transition: opacity 0.2s;
        border: none;
    }

    .btn-add-content:hover {
        opacity: 0.88;
        color: #fff;
    }

    /* ===== SIDEBAR WIDGETS ===== */
    .sidebar-widget {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .sidebar-widget .widget-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        background-color: #4CAF93;
    }

    .sidebar-widget .widget-header .bi {
        color: #fff;
        font-size: 16px;
    }

    .sidebar-widget .widget-header h2 {
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        margin: 0;
    }

    /* Nav list widget */
    .sidebar-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-nav-list li {
        border-bottom: 1px solid #f5f5f5;
    }

    .sidebar-nav-list li:last-child {
        border-bottom: none;
    }

    .sidebar-nav-list li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        font-size: 14px;
        color: #555;
        transition: background 0.15s, color 0.15s;
    }

    .sidebar-nav-list li a:hover,
    .sidebar-nav-list li a.active {
        background-color: #E8F5F1;
        color: #4CAF93;
        font-weight: 600;
    }

    .sidebar-nav-list li a .bi {
        font-size: 11px;
        color: #4CAF93;
        flex-shrink: 0;
    }

    /* Article list widget */
    .sidebar-article-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-article-list li {
        border-bottom: 1px solid #f5f5f5;
    }

    .sidebar-article-list li:last-child {
        border-bottom: none;
    }

    .sidebar-article-list li a {
        display: flex;
        gap: 12px;
        padding: 14px 20px;
        transition: background 0.15s;
        color: inherit;
    }

    .sidebar-article-list li a:hover {
        background-color: #E8F5F1;
    }

    .sidebar-article-thumb {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f0f0f0;
    }

    .sidebar-article-thumb img,
    .sidebar-article-thumb .thumb-placeholder {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-article-info p.title {
        font-size: 13px;
        font-weight: 500;
        color: #333;
        line-height: 1.5;
        margin: 0 0 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sidebar-article-info p.date {
        font-size: 12px;
        color: #999;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* PSB CTA Widget */
    .widget-psb {
        border-radius: 16px;
        overflow: hidden;
        background: linear-gradient(135deg, #4CAF93, #2d6a4f);
        padding: 32px 24px;
        text-align: center;
        color: #fff;
        margin-bottom: 24px;
    }

    .widget-psb .psb-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .widget-psb .psb-icon .bi {
        font-size: 28px;
        color: #fff;
    }

    .widget-psb h3 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .widget-psb p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0 0 20px;
    }

    .btn-psb-cta {
        display: inline-block;
        padding: 10px 28px;
        background: #fff;
        color: #4CAF93;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    }

    .btn-psb-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        color: #4CAF93;
    }

    /* Contact widget */
    .widget-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 0 20px 14px;
        font-size: 14px;
        color: #555;
    }

    .widget-contact-item .bi {
        color: #4CAF93;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .widget-contact-item a {
        color: #555;
        transition: color 0.2s;
    }

    .widget-contact-item a:hover {
        color: #4CAF93;
    }

    .widget-contact-body {
        padding-top: 16px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header-banner {
            padding: 28px 0;
        }

        .page-header-banner h1 {
            font-size: 20px;
        }

        .page-body {
            padding: 24px 0;
        }

        .article-card .article-body {
            padding: 16px;
        }

        .article-card .article-title {
            font-size: 18px;
        }
    }
</style>
@endsection

@section('content')

    {{-- ===== PAGE HEADER BANNER ===== --}}
    <div class="page-header-banner">
        <div class="container">
            <h1>{{ $visionMission->title ?? 'Visi Misi' }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Beranda</a></li>
                    <li><span class="mx-1">/</span></li>
                    <li><a href="/profil-sekolah">Profil Kami</a></li>
                    <li><span class="mx-1">/</span></li>
                    <li class="active">{{ $visionMission->title ?? 'Visi Misi' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- ===== MAIN LAYOUT: BOOTSTRAP 2-COLUMN GRID ===== --}}
    <div class="page-body">
        <div class="container">
            <div class="row">

                {{-- ============================= --}}
                {{-- LEFT COLUMN (8/12) — Main Content --}}
                {{-- ============================= --}}
                <div class="col-lg-8 col-12 mb-4 mb-lg-0">
                    <article class="article-card">

                        {{-- Feature Image --}}
                        @if($visionMission && $visionMission->feature_image)
                            <img src="{{ asset('storage/' . $visionMission->feature_image) }}"
                                 alt="{{ $visionMission->title ?? 'Visi & Misi' }}"
                                 class="feature-image">
                        @endif

                        {{-- Article Body --}}
                        <div class="article-body">
                            <h2 class="article-title">
                                {{ $visionMission->title ?? 'Visi Misi' }}
                            </h2>

                            @if($visionMission && $visionMission->content)
                                <div class="prose">
                                    {!! $visionMission->content !!}
                                </div>
                            @else
                                {{-- Empty state --}}
                                <div class="empty-state">
                                    <div class="icon-wrap">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <p class="lead">Konten Visi dan Misi belum tersedia.</p>
                                    <p class="sub">Silakan tambahkan melalui Admin Panel.</p>
                                    <a href="/admin/vision-missions/create" class="btn-add-content">
                                        <i class="bi bi-plus-circle"></i> Tambah Konten
                                    </a>

                                    {{-- Fallback preview content --}}
                                    <div class="mt-4 text-start prose">
                                        <h2>Visi</h2>
                                        <p>Iman, Ilmu, Ilmiah dan Amal Sholeh</p>
                                        <h2>Misi</h2>
                                        <ul>
                                            <li>Menumbuhkan keimanan, ketaqwaan, kejujuran dan rendah hati</li>
                                            <li>Menumbuhkan semangat kerja keras, mandiri, ulet, tidak mudah menyerah</li>
                                            <li>Membekali siswa dengan bernalar kritis, kreatif, komunikatif, dan kolaboratif</li>
                                            <li>Menumbuhkan dan mengamalkan budaya literasi</li>
                                        </ul>
                                        <h2>Tujuan</h2>
                                        <ul>
                                            <li>Memberikan pendidikan dan pengalaman terbaik, karena 5 tahun pertama adalah masa emas anak.</li>
                                            <li>Memfasilitasi tumbuh kembang anak secara sehat dan optimal sesuai norma dan nilai.</li>
                                            <li>Pendidikan anak usia dini merupakan proses saintifik dan bukan tempat penitipan anak.</li>
                                            <li>Pendidikan yang diberikan adalah pendidikan untuk hidup, bukan hanya untuk melanjutkan sekolah.</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                {{-- ============================= --}}
                {{-- RIGHT COLUMN (4/12) — Sidebar --}}
                {{-- ============================= --}}
                <div class="col-lg-4 col-12">

                    {{-- Widget 1: Navigasi Profil Kami --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            <h2>Profil Kami</h2>
                        </div>
                        @php
                            $navItems = [
                                ['label' => 'Profil Sekolah',  'url' => '/profil-sekolah', 'active' => false],
                                ['label' => 'Visi & Misi',     'url' => '/visi-misi',       'active' => true],
                                ['label' => 'Staf Pengajar',   'url' => '/#program',        'active' => false],
                                ['label' => 'Fasilitas',       'url' => '/#fasilitas',      'active' => false],
                                ['label' => 'Kontak Kami',     'url' => '/#kontak',         'active' => false],
                            ];
                        @endphp
                        <ul class="sidebar-nav-list">
                            @foreach($navItems as $nav)
                                <li>
                                    <a href="{{ $nav['url'] }}" class="{{ $nav['active'] ? 'active' : '' }}">
                                        <i class="bi bi-chevron-right"></i>
                                        {{ $nav['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Widget 2: Artikel Terbaru --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <i class="bi bi-newspaper"></i>
                            <h2>Artikel Terbaru</h2>
                        </div>
                        <ul class="sidebar-article-list">
                            @forelse($recentArticles as $article)
                                <li>
                                    <a href="#">
                                        <div class="sidebar-article-thumb">
                                            @if($article->image)
                                                <img src="{{ asset('storage/' . $article->image) }}"
                                                     alt="{{ $article->title }}">
                                            @else
                                                <div class="thumb-placeholder"
                                                     style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                                    <i class="bi bi-newspaper text-white" style="font-size:20px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="sidebar-article-info">
                                            <p class="title">{{ $article->title }}</p>
                                            <p class="date">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $article->published_at->format('d F Y') }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                @foreach([
                                    ['Kegiatan Outing Class Siswa TK Puspitasari', '8 Maret 2025'],
                                    ['Program Hafalan Asmaul Husna Semester 2',     '15 Februari 2025'],
                                    ['Peringatan Hari Pendidikan Nasional 2025',    '3 Januari 2025'],
                                    ['Pentas Seni & Perpisahan Semester 1',          '20 Desember 2024'],
                                ] as [$judul, $tgl])
                                    <li>
                                        <a href="#">
                                            <div class="sidebar-article-thumb">
                                                <div class="thumb-placeholder"
                                                     style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                                    <i class="bi bi-newspaper text-white" style="font-size:20px;"></i>
                                                </div>
                                            </div>
                                            <div class="sidebar-article-info">
                                                <p class="title">{{ $judul }}</p>
                                                <p class="date">
                                                    <i class="bi bi-calendar3"></i> {{ $tgl }}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endforelse
                        </ul>
                    </div>

                    {{-- Widget 3: PSB CTA --}}
                    <div class="widget-psb">
                        <div class="psb-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h3>PSB {{ date('Y') }}/{{ date('Y') + 1 }}</h3>
                        <p>Daftarkan putra-putri Anda sekarang!</p>
                        <a href="/register-student" class="btn-psb-cta">Daftar Sekarang</a>
                    </div>

                    {{-- Widget 4: Hubungi Kami --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <i class="bi bi-telephone-fill"></i>
                            <h2>Hubungi Kami</h2>
                        </div>
                        <div class="widget-contact-body">
                            <div class="widget-contact-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Kaliwatubumi, Butuh, Purworejo, Jawa Tengah</span>
                            </div>
                            <div class="widget-contact-item">
                                <i class="bi bi-whatsapp"></i>
                                <a href="https://wa.me/6285328209910" target="_blank">
                                    0853-2820-9910 (Ibu Kotijah)
                                </a>
                            </div>
                            <div class="widget-contact-item">
                                <i class="bi bi-whatsapp"></i>
                                <a href="https://wa.me/6282312474292" target="_blank">
                                    0823-1247-4292 (Ibu Sukowati)
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- END RIGHT COLUMN --}}

            </div>
            {{-- END .row --}}
        </div>
        {{-- END .container --}}
    </div>

@endsection
