@extends('layouts.app')

@section('title', 'Laman Berita — TK Puspitasari Kaliwatubumi')
@section('meta_description', 'Kumpulan berita, pengumuman, dan informasi terbaru dari TK Puspitasari Kaliwatubumi.')

@section('styles')
<style>
    /* ==================== PAGE HERO ==================== */
    .page-hero {
        background: linear-gradient(135deg, #1a2332 0%, #2d4a3e 100%);
        padding: 56px 0 48px;
        position: relative;
        overflow: hidden;
    }

    .page-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(76, 175, 147, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-hero-content {
        position: relative;
        z-index: 1;
    }

    .page-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(76, 175, 147, 0.2);
        border: 1px solid rgba(76, 175, 147, 0.4);
        color: #7ecfb5;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .page-hero h1 {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: #fff;
        margin: 0 0 12px;
        line-height: 1.2;
    }

    .page-hero p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        font-size: 13px;
        color: rgba(255,255,255,0.5);
    }

    .breadcrumb-nav a { color: rgba(255,255,255,0.7); transition: color 0.2s; }
    .breadcrumb-nav a:hover { color: #4CAF93; }
    .breadcrumb-nav span { color: #7ecfb5; font-weight: 600; }

    /* ==================== SECTION ==================== */
    .berita-section {
        padding: 60px 0 80px;
        background: #f7faf9;
    }

    /* ==================== CARD GRID ==================== */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-top: 40px;
    }

    @media (max-width: 992px) { .berita-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .berita-grid { grid-template-columns: 1fr; } }

    .berita-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .berita-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(76,175,147,0.18);
    }

    .card-thumbnail {
        position: relative;
        width: 100%;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: #e8f5f1;
        flex-shrink: 0;
    }

    .card-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .berita-card:hover .card-thumbnail img {
        transform: scale(1.06);
    }

    .card-thumbnail-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e8f5f1, #d0ede5);
    }

    .card-thumbnail-placeholder .bi {
        font-size: 48px;
        color: #4CAF93;
        opacity: 0.5;
    }

    .card-date-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(26,35,50,0.85);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-body {
        padding: 20px 22px 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a2332;
        margin: 0 0 10px;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-excerpt {
        font-size: 13.5px;
        color: #666;
        line-height: 1.65;
        margin: 0 0 18px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .card-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .card-read-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #4CAF93;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 16px;
        border-radius: 50px;
        transition: background 0.2s, transform 0.2s;
        white-space: nowrap;
    }

    .card-read-link:hover {
        background: #3a9478;
        color: #fff;
        transform: translateX(2px);
    }

    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #999;
    }

    .empty-state .bi {
        font-size: 64px;
        color: #c8e6dc;
        display: block;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: #555;
        margin: 0 0 8px;
    }

    .empty-state p { font-size: 14px; margin: 0; }

    /* ==================== PAGINATION ==================== */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 52px;
    }

    .pagination-wrapper nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination-wrapper nav .relative {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Override Laravel default pagination styling */
    .pagination-wrapper span[aria-current="page"] > span,
    .pagination-wrapper a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid #e0e0e0;
        color: #555;
        background: #fff;
    }

    .pagination-wrapper span[aria-current="page"] > span {
        background: #4CAF93;
        color: #fff;
        border-color: #4CAF93;
        font-weight: 700;
    }

    .pagination-wrapper a:hover {
        background: #e8f5f1;
        border-color: #4CAF93;
        color: #3a9478;
    }

    .pagination-wrapper span > span.cursor-default {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 13px;
        background: #f5f5f5;
        color: #bbb;
        border: 1px solid #e0e0e0;
    }

    /* ==================== HEADER SECTION ==================== */
    .section-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label-bar {
        width: 4px;
        height: 28px;
        background: linear-gradient(to bottom, #4CAF93, #3a9478);
        border-radius: 4px;
    }

    .section-label h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1a2332;
        margin: 0;
    }

    .section-label p {
        font-size: 13px;
        color: #888;
        margin: 2px 0 0;
    }

    .total-badge {
        background: #e8f5f1;
        color: #3a9478;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
    }
</style>
@endsection

@section('content')

    {{-- ===================== PAGE HERO ===================== --}}
    <section class="page-hero">
        <div class="container">
            <div class="page-hero-content">
                <div class="page-hero-badge">
                    <i class="bi bi-newspaper"></i> Portal Berita
                </div>
                <h1>Laman Berita &amp; Informasi</h1>
                <p>Kumpulan berita, pengumuman, dan informasi terbaru dari TK Puspitasari Kaliwatubumi.</p>
                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                    <a href="/"><i class="bi bi-house-fill"></i> Beranda</a>
                    <i class="bi bi-chevron-right" style="font-size:10px;"></i>
                    <span>Laman Berita</span>
                </nav>
            </div>
        </div>
    </section>

    {{-- ===================== DAFTAR BERITA ===================== --}}
    <section class="berita-section">
        <div class="container">

            <div class="section-top-row">
                <div class="section-label">
                    <div class="section-label-bar"></div>
                    <div>
                        <h2>Semua Berita</h2>
                        <p>{{ $articles->total() }} artikel ditemukan</p>
                    </div>
                </div>
                @if($articles->total() > 0)
                    <span class="total-badge">Halaman {{ $articles->currentPage() }} / {{ $articles->lastPage() }}</span>
                @endif
            </div>

            @if($articles->count() > 0)
                <div class="berita-grid">
                    @foreach($articles as $article)
                        <article class="berita-card">
                            <div class="card-thumbnail">
                                @if($article->thumbnail_url)
                                    <img src="{{ $article->thumbnail_url }}"
                                         alt="{{ $article->title }}"
                                         loading="lazy">
                                @else
                                    <div class="card-thumbnail-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div class="card-date-badge">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $article->published_at->translatedFormat('d M Y') }}
                                </div>
                            </div>

                            <div class="card-body">
                                <h3 class="card-title">{{ $article->title }}</h3>
                                <p class="card-excerpt">{{ $article->excerpt }}</p>

                                <div class="card-footer-row">
                                    <span style="font-size:12px; color:#aaa;">
                                        <i class="bi bi-clock"></i>
                                        {{ $article->published_at->diffForHumans() }}
                                    </span>
                                    <a href="{{ route('berita.show', ['article' => $article->slug]) }}" class="card-read-link">
                                        Baca Selengkapnya
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    {{ $articles->links() }}
                </div>

            @else
                <div class="empty-state">
                    <i class="bi bi-journal-x"></i>
                    <h3>Belum Ada Berita</h3>
                    <p>Berita akan ditampilkan di sini setelah admin menambahkannya.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
