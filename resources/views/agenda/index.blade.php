@extends('layouts.app')
@section('title', 'Agenda - TK Puspitasari Kaliwatubumi')

@section('content')
@php
    use App\Models\Agenda;
    use App\Models\Article;
    $agendas = Agenda::orderBy('event_date', 'asc')->get() ?? collect();
    $recent_articles = Article::latest('published_at')->take(4)->get() ?? collect();
@endphp

<style>
    .archive-header { background-color: #5ad1f1 !important; padding: 40px 0; margin-bottom: 40px; text-align: left; }
    .archive-header h1 { color: #fff; font-weight: 700; margin: 0; font-size: 32px; }
    .archive-agenda-item { background-color: #E8F5FF !important; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
    .archive-agenda-item .wrapper { display: flex; align-items: center; border-bottom: 2px solid #5AD1F1 !important; padding-bottom: 12px; margin-bottom: 12px; }
    .archive-agenda-item .bi { color: #5AD1F1 !important; font-size: 24px; margin-right: 15px; }
    .archive-agenda-item h5 { color: #333333 !important; margin: 0; font-weight: 600; font-size: 16px; }
    .archive-agenda-item p { color: #333333 !important; margin: 0; font-size: 14px; }
    
    .sidebar .widget { background-color: #fcfcfc; padding: 25px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #eee; }
    .sidebar .widgettitle { font-size: 18px; font-weight: 700; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #5ad1f1; color: #333; }
    .recent-entries-list { list-style: none; padding: 0; margin: 0; }
    .recent-entries-list li { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #ddd; }
    .recent-entries-list li:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0; }
    .recent-entries-list a { color: #333; font-weight: 600; text-decoration: none; display: block; margin-bottom: 5px; transition: color 0.2s; }
    .recent-entries-list a:hover { color: #5ad1f1; }
    .recent-entries-list .post-date { font-size: 12px; color: #888; }
</style>

<div class="archive-header">
    <div class="container">
        <h1><span>Agenda</span></h1>
    </div>
</div>

<div class="archive-page" style="padding-bottom: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="archive-agenda-list">
                    @forelse($agendas as $ag)
                        <div class="archive-agenda-item">
                            <div class="wrapper">
                                <i class="bi bi-calendar-check"></i>
                                <h5>{{ $ag->title }}</h5>
                            </div>
                            <p class="tanggal-agenda">{{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d F Y') }}</p>
                        </div>
                    @empty
                        <div class="archive-agenda-item">
                            <div class="wrapper">
                                <i class="bi bi-calendar-check"></i>
                                <h5>Kelulusan dan Kenaikan Kelas TA 2024-2025</h5>
                            </div>
                            <p class="tanggal-agenda">28-29 Juni 2025</p>
                        </div>
                        <div class="archive-agenda-item">
                            <div class="wrapper">
                                <i class="bi bi-calendar-check"></i>
                                <h5>Libur Akhir Semester TA 2024-2025</h5>
                            </div>
                            <p class="tanggal-agenda">30 Juni - 12 Juli 2025</p>
                        </div>
                        <div class="archive-agenda-item">
                            <div class="wrapper">
                                <i class="bi bi-calendar-check"></i>
                                <h5>Pembagian Raport Semester 2 TA 2024-2025</h5>
                            </div>
                            <p class="tanggal-agenda">28 Juni 2025</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4 sidebar">
                <div class="widget">
                    <h2 class="widgettitle">Teks Widget Agenda</h2>
                    <div class="textwidget">Ini adalah contoh widget pada halaman Agenda TK Puspitasari Kaliwatubumi.</div>
                </div>

                <div class="widget">
                    <h2 class="widgettitle">Artikel Terbaru</h2>
                    <ul class="recent-entries-list">
                        @forelse($recent_articles as $art)
                            <li>
                                <a href="#">{{ $art->title }}</a>
                                <span class="post-date">{{ \Carbon\Carbon::parse($art->published_at)->translatedFormat('d F Y') }}</span>
                            </li>
                        @empty
                            <li>
                                <a href="#">Berkunjung Ke Pasar Tradisional</a>
                                <span class="post-date">Maret 8, 2025</span>
                            </li>
                            <li>
                                <a href="#">Outing Class Berkunjung ke Damkar</a>
                                <span class="post-date">Februari 21, 2025</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
