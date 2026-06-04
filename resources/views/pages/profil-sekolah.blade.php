@extends('layouts.app')

@section('title', ($profile->title ?? 'Profil Sekolah') . ' — TK Puspitasari Kaliwatubumi')

{{-- Inject Tailwind CDN explicitly so all utility classes are available --}}
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
        .content-area blockquote { @apply border-l-4 border-green-400 pl-4 italic text-gray-600 my-4; }
        .content-area img { @apply rounded-lg max-w-full h-auto my-4; }
        .content-area table { @apply w-full border-collapse my-4 text-sm; }
        .content-area th { @apply bg-gray-50 font-semibold text-left px-3 py-2 border border-gray-200; }
        .content-area td { @apply px-3 py-2 border border-gray-200; }
    }
</style>
@endsection

@section('content')

{{-- ===== PAGE HEADER BANNER ===== --}}
<div style="background-color:#4CAF93;" class="w-full py-10 px-4">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-white mb-1">
            {{ $profile->title ?? 'Profil Sekolah' }}
        </h1>
        <nav class="text-sm text-white/80 flex items-center gap-1">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="mx-1">/</span>
            <span class="text-white font-medium">{{ $profile->title ?? 'Profil Sekolah' }}</span>
        </nav>
    </div>
</div>

{{-- ===== MAIN LAYOUT: 2 COLUMNS ===== --}}
<div class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row gap-8">

        {{-- ============================= --}}
        {{-- LEFT COLUMN (2/3) — Main Content --}}
        {{-- ============================= --}}
        <main class="w-full lg:w-2/3">
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Feature Image --}}
                @if($profile && $profile->feature_image)
                <div class="w-full">
                    <img
                        src="{{ asset('storage/' . $profile->feature_image) }}"
                        alt="{{ $profile->title ?? 'Profil Sekolah' }}"
                        class="w-full object-cover"
                        style="max-height:420px;"
                    >
                </div>
                @endif

                {{-- Article Content --}}
                <div class="p-6 lg:p-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1 pb-4 border-b border-gray-100">
                        {{ $profile->title ?? 'Profil Sekolah' }}
                    </h2>

                    @if($profile && $profile->content)
                    <div class="content-area mt-6 text-gray-700 leading-relaxed text-base">
                        {!! $profile->content !!}
                    </div>
                    @else
                    {{-- Empty state --}}
                    <div class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                             style="background-color:#E8F5F1;">
                            <i class="bi bi-building text-3xl" style="color:#4CAF93;"></i>
                        </div>
                        <p class="text-gray-600 font-medium">Konten profil sekolah belum tersedia.</p>
                        <p class="text-gray-400 text-sm mt-1">Silakan tambahkan melalui Admin Panel.</p>
                        <a href="/admin/school-profiles/create"
                           class="inline-flex items-center gap-2 mt-5 px-6 py-2 rounded-full text-white text-sm font-semibold transition-all hover:opacity-90"
                           style="background-color:#4CAF93;">
                            <i class="bi bi-plus-circle"></i> Tambah Konten
                        </a>
                    </div>
                    @endif
                </div>
            </article>
        </main>

        {{-- ============================= --}}
        {{-- RIGHT COLUMN (1/3) — Sidebar --}}
        {{-- ============================= --}}
        <aside class="w-full lg:w-1/3 flex flex-col gap-6">

            {{-- Widget 1: Navigasi Profil Kami --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-4" style="background-color:#4CAF93;">
                    <i class="bi bi-grid-3x3-gap-fill text-white"></i>
                    <h2 class="text-base font-bold text-white">Profil Kami</h2>
                </div>
                <ul class="divide-y divide-gray-50">
                    @php
                    $navItems = [
                        ['label' => 'Profil Sekolah',    'url' => '/profil-sekolah', 'active' => request()->is('profil-sekolah')],
                        ['label' => 'Staf Pengajar',     'url' => '/#program',       'active' => false],
                        ['label' => 'Fasilitas',         'url' => '/#fasilitas',     'active' => false],
                        ['label' => 'Agenda Kegiatan',   'url' => '/#agenda',        'active' => false],
                        ['label' => 'Kontak Kami',       'url' => '/#kontak',        'active' => false],
                    ];
                    @endphp
                    @foreach($navItems as $nav)
                    <li>
                        <a href="{{ $nav['url'] }}"
                           class="flex items-center gap-3 px-5 py-3 text-sm transition-colors {{ $nav['active'] ? 'font-semibold bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}"
                           style="{{ $nav['active'] ? 'color:#4CAF93;' : '' }}">
                            <i class="bi bi-chevron-right text-xs flex-shrink-0" style="color:#4CAF93;"></i>
                            {{ $nav['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Widget 2: Artikel Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-4" style="background-color:#4CAF93;">
                    <i class="bi bi-newspaper text-white"></i>
                    <h2 class="text-base font-bold text-white">Artikel Terbaru</h2>
                </div>
                <ul class="divide-y divide-gray-50">
                    @forelse($recentArticles as $article)
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
                                    {{ $article->published_at->format('d F Y') }}
                                </p>
                            </div>
                        </a>
                    </li>
                    @empty
                    {{-- Fallback articles if DB is empty --}}
                    @foreach([
                        ['Kegiatan Outing Class Siswa TK Puspitasari', '8 Maret 2025'],
                        ['Program Hafalan Asmaul Husna Semester 2',    '15 Februari 2025'],
                        ['Peringatan Hari Pendidikan Nasional 2025',   '3 Januari 2025'],
                        ['Pentas Seni & Perpisahan Semester 1',        '20 Desember 2024'],
                    ] as [$judul, $tgl])
                    <li>
                        <a href="#" class="flex gap-3 px-5 py-4 hover:bg-green-50 transition-colors group">
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl flex items-center justify-center"
                                 style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                <i class="bi bi-newspaper text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 leading-snug group-hover:text-green-700 transition-colors"
                                   style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $judul }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-calendar3"></i>{{ $tgl }}
                                </p>
                            </div>
                        </a>
                    </li>
                    @endforeach
                    @endforelse
                </ul>
            </div>

            {{-- Widget 3: PSB Call-to-Action --}}
            <div class="rounded-2xl overflow-hidden shadow-sm p-8 text-center text-white"
                 style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-mortarboard-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold mb-1">PSB {{ date('Y') }}/{{ date('Y') + 1 }}</h3>
                <p class="text-sm text-white/80 mb-5">Daftarkan putra-putri Anda dan bergabung bersama keluarga besar TK Puspitasari!</p>
                <a href="/register-student"
                   class="inline-block px-7 py-2.5 bg-white rounded-full text-sm font-bold shadow-lg transition-all hover:shadow-xl hover:scale-105"
                   style="color:#4CAF93;">
                    Daftar Sekarang
                </a>
            </div>

            {{-- Widget 4: Hubungi Kami --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-4" style="background-color:#4CAF93;">
                    <i class="bi bi-telephone-fill text-white"></i>
                    <h2 class="text-base font-bold text-white">Hubungi Kami</h2>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <i class="bi bi-geo-alt-fill mt-0.5 flex-shrink-0" style="color:#4CAF93;"></i>
                        <span>Kaliwatubumi, Butuh, Purworejo, Jawa Tengah</span>
                    </div>
                    <a href="https://wa.me/6285328209910" target="_blank"
                       class="flex items-center gap-3 text-sm text-gray-700 hover:text-green-700 transition-colors">
                        <i class="bi bi-whatsapp flex-shrink-0" style="color:#4CAF93;"></i>
                        <span>0853-2820-9910 (Ibu Kotijah)</span>
                    </a>
                    <a href="https://wa.me/6282312474292" target="_blank"
                       class="flex items-center gap-3 text-sm text-gray-700 hover:text-green-700 transition-colors">
                        <i class="bi bi-whatsapp flex-shrink-0" style="color:#4CAF93;"></i>
                        <span>0823-1247-4292 (Ibu Sukowati)</span>
                    </a>
                </div>
            </div>

        </aside>
    </div>
</div>

@endsection
