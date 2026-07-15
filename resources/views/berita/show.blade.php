@extends('layouts.app')

@section('title', $article->title . ' — TK Puspitasari Kaliwatubumi')
@section('meta_description', Str::limit($article->excerpt, 160))

@section('styles')
<style>
    /* ==================== ARTICLE HERO ==================== */
    .article-hero {
        position: relative;
        width: 100%;
        max-height: 520px;
        overflow: hidden;
        background: #1a2332;
    }

    .article-hero-img {
        width: 100%;
        height: 520px;
        object-fit: cover;
        opacity: 0.75;
        display: block;
    }

    .article-hero-placeholder {
        width: 100%;
        height: 340px;
        background: linear-gradient(135deg, #1a2332 0%, #2d4a3e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .article-hero-placeholder .bi {
        font-size: 80px;
        color: rgba(76,175,147,0.35);
    }

    .article-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(26,35,50,0.15) 0%,
            rgba(26,35,50,0.35) 50%,
            rgba(26,35,50,0.85) 100%
        );
        display: flex;
        align-items: flex-end;
    }

    .article-hero-meta {
        padding: 36px 0 40px;
        width: 100%;
    }

    .article-hero-meta .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        margin-bottom: 16px;
    }

    .article-hero-meta .breadcrumb-nav a {
        color: rgba(255,255,255,0.75);
        transition: color 0.2s;
    }

    .article-hero-meta .breadcrumb-nav a:hover { color: #7ecfb5; }
    .article-hero-meta .breadcrumb-nav span { color: #7ecfb5; }

    .article-hero-title {
        font-size: clamp(22px, 3.5vw, 38px);
        font-weight: 800;
        color: #fff;
        line-height: 1.25;
        margin: 0 0 16px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .article-meta-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255,255,255,0.8);
    }

    .article-meta-item .bi {
        color: #7ecfb5;
        font-size: 14px;
    }

    /* ==================== ARTICLE LAYOUT ==================== */
    .article-layout {
        background: #f7faf9;
        padding: 56px 0 80px;
    }

    .article-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 36px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .article-grid { grid-template-columns: 1fr; }
        .article-sidebar { order: 2; }
    }

    /* ==================== ARTICLE CONTENT ==================== */
    .article-content-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px 44px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    }

    @media (max-width: 576px) {
        .article-content-card { padding: 24px 20px; }
    }

    .article-excerpt-block {
        font-size: 17px;
        font-weight: 500;
        color: #3a4a5c;
        line-height: 1.7;
        padding: 20px 24px;
        background: #eef8f4;
        border-left: 4px solid #4CAF93;
        border-radius: 0 12px 12px 0;
        margin-bottom: 32px;
    }

    .article-body {
        font-size: 16px;
        line-height: 1.85;
        color: #333;
    }

    .article-body h1, .article-body h2, .article-body h3,
    .article-body h4, .article-body h5, .article-body h6 {
        font-weight: 700;
        color: #1a2332;
        margin-top: 28px;
        margin-bottom: 12px;
    }

    .article-body h2 { font-size: 22px; border-bottom: 2px solid #e8f5f1; padding-bottom: 8px; }
    .article-body h3 { font-size: 18px; }

    .article-body p { margin-bottom: 18px; }

    .article-body img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 24px 0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .article-body a {
        color: #4CAF93;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .article-body a:hover { color: #3a9478; }

    .article-body ul, .article-body ol {
        padding-left: 24px;
        margin-bottom: 18px;
    }

    .article-body li { margin-bottom: 8px; }

    .article-body blockquote {
        border-left: 4px solid #4CAF93;
        background: #f0faf6;
        padding: 16px 20px;
        border-radius: 0 10px 10px 0;
        margin: 20px 0;
        font-style: italic;
        color: #555;
    }

    .article-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 14px;
    }

    .article-body th, .article-body td {
        border: 1px solid #e0e0e0;
        padding: 10px 14px;
        text-align: left;
    }

    .article-body th {
        background: #e8f5f1;
        font-weight: 600;
        color: #2d6a55;
    }

    /* Hide Trix attachment caption (filename & size) */
    .article-body .attachment__caption {
        display: none !important;
    }

    /* ==================== SHARE & BACK ==================== */
    .article-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 36px;
        padding-top: 24px;
        border-top: 2px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 14px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #555;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 18px;
        border: 1px solid #ddd;
        border-radius: 50px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #4CAF93;
        color: #fff;
        border-color: #4CAF93;
    }

    .share-label {
        font-size: 13px;
        color: #888;
        font-weight: 500;
        margin-right: 6px;
    }

    .share-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .share-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: transform 0.2s, opacity 0.2s;
        color: #fff;
    }

    .share-btn:hover { transform: scale(1.12); opacity: 0.9; }
    .share-btn.wa { background: #25d366; }
    .share-btn.fb { background: #1877f2; }
    .share-btn.tw { background: #1da1f2; }
    .share-btn.cp { background: #888; }

    /* ==================== SIDEBAR ==================== */
    .article-sidebar { }

    .sidebar-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        margin-bottom: 24px;
    }

    .sidebar-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 700;
        color: #1a2332;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e8f5f1;
    }

    .sidebar-title .bi {
        color: #4CAF93;
        font-size: 18px;
    }

    /* Related Articles */
    .related-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.15s;
    }

    .related-item:last-child { border-bottom: none; padding-bottom: 0; }
    .related-item:first-child { padding-top: 0; }

    .related-item-thumb {
        width: 68px;
        height: 52px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: #e8f5f1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-item-thumb .bi { color: #4CAF93; font-size: 22px; opacity: 0.5; }

    .related-item-info { flex: 1; min-width: 0; }

    .related-item-title {
        font-size: 13px;
        font-weight: 600;
        color: #1a2332;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
        transition: color 0.15s;
    }

    .related-item:hover .related-item-title { color: #4CAF93; }

    .related-item-date {
        font-size: 11px;
        color: #aaa;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Info Sekolah Card */
    .school-info-card {
        background: linear-gradient(135deg, #4CAF93, #3a9478);
        border-radius: 16px;
        padding: 24px;
        color: #fff;
    }

    .school-info-card h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 6px;
        color: #fff;
    }

    .school-info-card p {
        font-size: 13px;
        color: rgba(255,255,255,0.85);
        margin: 0 0 18px;
        line-height: 1.55;
    }

    .school-info-card a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: #3a9478;
        font-size: 13px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 50px;
        transition: background 0.2s;
    }

    .school-info-card a:hover { background: #e8f5f1; }
</style>
@endsection

@section('content')

    {{-- ===================== ARTICLE HERO ===================== --}}
    <div class="article-hero">
        @if($article->thumbnail_url)
            <img class="article-hero-img" src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}">
            <div class="article-hero-overlay">
                <div class="container">
                    <div class="article-hero-meta">
                        <nav class="breadcrumb-nav" aria-label="breadcrumb">
                            <a href="/"><i class="bi bi-house-fill"></i> Beranda</a>
                            <i class="bi bi-chevron-right" style="font-size:10px;"></i>
                            <a href="{{ route('berita.index') }}">Laman Berita</a>
                            <i class="bi bi-chevron-right" style="font-size:10px;"></i>
                            <span>{{ Str::limit($article->title, 40) }}</span>
                        </nav>
                        <h1 class="article-hero-title">{{ $article->title }}</h1>
                        <div class="article-meta-row">
                            <div class="article-meta-item">
                                <i class="bi bi-calendar3"></i>
                                {{ $article->published_at->translatedFormat('d F Y') }}
                            </div>
                            <div class="article-meta-item">
                                <i class="bi bi-clock"></i>
                                {{ $article->published_at->diffForHumans() }}
                            </div>
                            <div class="article-meta-item">
                                <i class="bi bi-building"></i>
                                TK Puspitasari
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="article-hero-placeholder">
                <i class="bi bi-newspaper"></i>
            </div>
        @endif
    </div>

    {{-- ===================== NO IMAGE: Tampilkan header di bawah ===================== --}}
    @if(!$article->thumbnail_url)
    <div style="background:#1a2332; padding:36px 0 32px;">
        <div class="container">
            <nav class="breadcrumb-nav" style="margin-bottom:16px;">
                <a href="/" style="color:rgba(255,255,255,0.7)"><i class="bi bi-house-fill"></i> Beranda</a>
                <i class="bi bi-chevron-right" style="font-size:10px; color:rgba(255,255,255,0.4)"></i>
                <a href="{{ route('berita.index') }}" style="color:rgba(255,255,255,0.7)">Laman Berita</a>
                <i class="bi bi-chevron-right" style="font-size:10px; color:rgba(255,255,255,0.4)"></i>
                <span style="color:#7ecfb5;">{{ Str::limit($article->title, 40) }}</span>
            </nav>
            <h1 style="font-size:clamp(22px,3.5vw,36px); font-weight:800; color:#fff; margin:0 0 14px; line-height:1.25;">
                {{ $article->title }}
            </h1>
            <div class="article-meta-row">
                <div class="article-meta-item" style="color:rgba(255,255,255,0.75);">
                    <i class="bi bi-calendar3" style="color:#7ecfb5;"></i>
                    {{ $article->published_at->translatedFormat('d F Y') }}
                </div>
                <div class="article-meta-item" style="color:rgba(255,255,255,0.75);">
                    <i class="bi bi-clock" style="color:#7ecfb5;"></i>
                    {{ $article->published_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===================== ARTIKEL + SIDEBAR ===================== --}}
    <section class="article-layout">
        <div class="container">
            <div class="article-grid">

                {{-- ── Kolom Konten ── --}}
                <main>
                    <div class="article-content-card">

                        {{-- Ringkasan / Excerpt --}}
                        @if($article->excerpt)
                            <p class="article-excerpt-block">{{ $article->excerpt }}</p>
                        @endif

                        {{-- Isi Berita --}}
                        <div class="article-body">
                            {!! $article->content !!}
                        </div>

                        {{-- Share & Kembali --}}
                        <div class="article-actions">
                            <a href="{{ route('berita.index') }}" class="btn-back">
                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                            </a>

                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <span class="share-label">Bagikan:</span>
                                <div class="share-buttons">
                                    <a class="share-btn wa"
                                       href="https://wa.me/?text={{ urlencode($article->title . ' — ' . request()->url()) }}"
                                       target="_blank" title="Bagikan via WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    <a class="share-btn fb"
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                       target="_blank" title="Bagikan ke Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a class="share-btn tw"
                                       href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                                       target="_blank" title="Bagikan ke Twitter/X">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                    <button class="share-btn cp" title="Salin link"
                                            onclick="navigator.clipboard.writeText('{{ request()->url() }}').then(() => { this.innerHTML='<i class=\'bi bi-check-lg\'></i>'; setTimeout(() => this.innerHTML='<i class=\'bi bi-link-45deg\'></i>', 1800); })">
                                        <i class="bi bi-link-45deg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>

                {{-- ── Sidebar ── --}}
                <aside class="article-sidebar">

                    {{-- Berita Terkait --}}
                    @if($relatedArticles->count() > 0)
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">
                            <i class="bi bi-collection"></i> Berita Terkait
                        </h3>
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('berita.show', ['article' => $related->slug]) }}" class="related-item" style="text-decoration:none; display:flex;">
                                <div class="related-item-thumb">
                                    @if($related->thumbnail_url)
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}">
                                    @else
                                        <i class="bi bi-image"></i>
                                    @endif
                                </div>
                                <div class="related-item-info">
                                    <div class="related-item-title">{{ $related->title }}</div>
                                    <div class="related-item-date">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $related->published_at->format('d M Y') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @endif

                    {{-- Card PSB --}}
                    <div class="school-info-card">
                        <h4><i class="bi bi-mortarboard-fill"></i> Pendaftaran Siswa Baru</h4>
                        <p>Daftarkan putra-putri Anda sekarang dan bergabung bersama keluarga besar TK Puspitasari!</p>
                        <a href="{{ url('/portal/ppdb') }}">
                            <i class="bi bi-pencil-square"></i>
                            Daftar Sekarang
                        </a>
                    </div>

                    {{-- Semua Berita --}}
                    <div class="sidebar-card" style="text-align:center;">
                        <i class="bi bi-newspaper" style="font-size:32px; color:#4CAF93; margin-bottom:10px; display:block;"></i>
                        <p style="font-size:13px; color:#777; margin:0 0 14px;">Lihat semua artikel dan pengumuman dari sekolah kami.</p>
                        <a href="{{ route('berita.index') }}"
                           style="display:inline-flex; align-items:center; gap:6px; background:#4CAF93; color:#fff; padding:8px 20px; border-radius:50px; font-size:13px; font-weight:600;">
                            <i class="bi bi-grid-3x3-gap"></i> Semua Berita
                        </a>
                    </div>

                </aside>
            </div>
        </div>
    </section>

@endsection
