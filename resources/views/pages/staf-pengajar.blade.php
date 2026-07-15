@extends('layouts.app')

@section('title', 'Staf Pengajar — TK Puspitasari Kaliwatubumi')

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

{{-- ===== PAGE HEADER BANNER ===== --}}
<div style="background-color:#4CAF93;" class="w-full py-10 px-4">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-white mb-1">Staf Pengajar</h1>
        <nav class="text-sm text-white/80 flex items-center gap-1">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="mx-1">/</span>
            <span class="text-white font-medium">Staf Pengajar</span>
        </nav>
    </div>
</div>

{{-- ===== MAIN LAYOUT ===== --}}
<div class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Tenaga Pendidik & Kependidikan</h2>
            <p class="text-gray-600">Mengenal lebih dekat profil guru dan staf di TK Puspitasari Kaliwatubumi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($teachers as $teacher)
            <article id="guru-{{ $teacher->id }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col sm:flex-row transition-all hover:shadow-md">
                
                {{-- Foto Guru --}}
                <div class="w-full sm:w-1/3 flex-shrink-0 bg-gray-100 relative">
                    @php
                        $photoUrl = $teacher->image 
                            ? asset('storage/' . $teacher->image) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($teacher->name) . '&background=4CAF93&color=fff&size=200';
                    @endphp
                    <div class="aspect-square sm:aspect-auto sm:h-full bg-cover bg-center" style="background-image: url('{{ $photoUrl }}')"></div>
                </div>

                {{-- Biodata --}}
                <div class="p-6 sm:w-2/3 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $teacher->name }}</h3>
                    <p class="text-green-600 font-semibold text-sm mb-4 pb-4 border-b border-gray-100">{{ $teacher->position }}</p>
                    
                    <div class="content-area text-sm text-gray-700 flex-grow">
                        @if($teacher->bio)
                            {!! $teacher->bio !!}
                        @else
                            <p class="text-gray-400 italic">Biodata belum ditambahkan.</p>
                        @endif
                    </div>
                </div>
                
            </article>
            @endforeach
        </div>

        @if($teachers->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color:#E8F5F1;">
                <i class="bi bi-person-x text-3xl" style="color:#4CAF93;"></i>
            </div>
            <p class="text-gray-600 font-medium">Data staf pengajar belum tersedia.</p>
        </div>
        @endif

    </div>
</div>

@endsection
