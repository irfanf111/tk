@extends('layouts.app')

@section('title', 'Agenda Sekolah — TK Puspitasari Kaliwatubumi')

@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style type="text/tailwindcss">
    @layer utilities {
        .content-area h1 { @apply text-3xl font-bold text-gray-900 mt-6 mb-3; }
        .content-area h2 { @apply text-2xl font-bold text-gray-800 mt-5 mb-2; }
        .content-area h3 { @apply text-xl font-semibold text-gray-800 mt-4 mb-2; }
        .content-area p  { @apply text-gray-700 leading-relaxed mb-4; }
        .content-area ul { @apply list-disc pl-6 mb-4 text-gray-700 space-y-1; }
        .content-area ol { @apply list-decimal pl-6 mb-4 text-gray-700 space-y-1; }
        .content-area a  { @apply text-green-600 underline hover:text-green-800; }
        .content-area strong { @apply font-semibold text-gray-900; }
    }
</style>
@endsection

@section('content')
@php
    use App\Models\Agenda;
    use App\Models\Article;
    $agendas = Agenda::orderBy('event_date', 'asc')->get() ?? collect();
    $recent_articles = Article::latest('published_at')->take(4)->get() ?? collect();
@endphp

{{-- ===== PAGE HEADER BANNER ===== --}}
<div style="background-color:#4CAF93;" class="w-full py-10 px-4">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-white mb-1">Agenda Sekolah</h1>
        <nav class="text-sm text-white/80 flex items-center gap-1">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="mx-1">/</span>
            <span class="text-white font-medium">Agenda</span>
        </nav>
    </div>
</div>

{{-- ===== MAIN LAYOUT: 2 COLUMNS ===== --}}
<div class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row gap-8">

        {{-- ============================= --}}
        {{-- LEFT COLUMN (2/3) — Agenda List --}}
        {{-- ============================= --}}
        <main class="w-full lg:w-2/3 flex flex-col gap-6">
            @forelse($agendas as $ag)
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col sm:flex-row transition-all hover:shadow-md">
                    {{-- Date Block --}}
                    <div class="sm:w-48 flex-shrink-0 flex flex-col items-center justify-center p-6 text-center border-b sm:border-b-0 sm:border-r border-gray-100" style="background:linear-gradient(135deg, #f8fdfb 0%, #ffffff 100%);">
                        <i class="bi bi-calendar-event text-3xl mb-2" style="color:#4CAF93;"></i>
                        <span class="text-sm font-bold text-gray-800">
                            @if($ag->end_date)
                                {{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d M Y') }} - <br>
                                {{ \Carbon\Carbon::parse($ag->end_date)->translatedFormat('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d F Y') }}
                            @endif
                        </span>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 sm:p-8 flex-1">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">{{ $ag->title }}</h2>
                        @if($ag->description)
                            <div class="content-area text-sm text-gray-600">
                                {!! nl2br(e($ag->description)) !!}
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak ada deskripsi tambahan.</p>
                        @endif
                    </div>
                </article>
            @empty
                {{-- Fallback jika agenda kosong --}}
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                         style="background-color:#E8F5F1;">
                        <i class="bi bi-calendar-x text-3xl" style="color:#4CAF93;"></i>
                    </div>
                    <p class="text-gray-600 font-medium">Belum ada agenda sekolah terbaru.</p>
                </div>
            @endforelse
        </main>

        {{-- ============================= --}}
        {{-- RIGHT COLUMN (1/3) — Sidebar --}}
        {{-- ============================= --}}
        <aside class="w-full lg:w-1/3 flex flex-col gap-6">

            {{-- Widget 1: Artikel Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-4" style="background-color:#4CAF93;">
                    <i class="bi bi-newspaper text-white"></i>
                    <h2 class="text-base font-bold text-white">Artikel Terbaru</h2>
                </div>
                <ul class="divide-y divide-gray-50">
                    @forelse($recent_articles as $article)
                    <li>
                        <a href="{{ route('berita.show', ['article' => $article->slug]) }}" class="flex gap-3 px-5 py-4 hover:bg-green-50 transition-colors group">
                            {{-- Thumbnail --}}
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}"
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                        <i class="bi bi-image text-white text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            {{-- Text --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 leading-snug group-hover:text-green-700 transition-colors"
                                   style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $article->title }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-calendar3"></i>
                                    {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="px-5 py-4 text-sm text-gray-500 italic text-center">Belum ada artikel.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Widget 2: PSB Call-to-Action --}}
            <div class="rounded-2xl overflow-hidden shadow-sm p-8 text-center text-white"
                 style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-mortarboard-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold mb-1">PSB {{ date('Y') }}/{{ date('Y') + 1 }}</h3>
                <p class="text-sm text-white/80 mb-5">Daftarkan putra-putri Anda dan bergabung bersama keluarga besar TK Puspitasari!</p>
                <a href="/portal/ppdb"
                   class="inline-block px-7 py-2.5 bg-white rounded-full text-sm font-bold shadow-lg transition-all hover:shadow-xl hover:scale-105"
                   style="color:#4CAF93;">
                    Daftar Sekarang
                </a>
            </div>

        </aside>

    </div>
</div>
@endsection
