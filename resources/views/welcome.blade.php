@extends('layouts.app')

@section('title', 'Welcome to TK Puspitasari')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="relative overflow-hidden bg-white">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-indigo-200 to-purple-400 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 sm:pt-32 sm:pb-32 lg:pb-40">
        <div class="lg:grid lg:grid-cols-12 lg:gap-16">
            <div class="md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:flex lg:items-center">
                <div>
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-500/20 bg-indigo-50/50">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 mr-2"></span>
                            Penerimaan Peserta Didik Baru {{ date('Y') }}/{{ date('Y') + 1 }}
                        </div>
                        <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-bold text-red-600 ring-1 ring-inset ring-red-500/20 bg-red-50/50">
                            🏆 Akreditasi B
                        </div>
                    </div>

                    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl md:text-6xl lg:text-6xl lg:leading-[1.15]">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Cerdas, Taqwa, Kreatif</span>
                        <br>Bersama TK Puspitasari
                    </h1>

                    <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-2xl">
                        Ayo bergabung bersama kami di TK Puspitasari Kaliwatubumi! Kami menyediakan lingkungan belajar yang Islami, menyenangkan, dan berdedikasi untuk mengembangkan potensi terbaik ananda.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4 sm:items-center">
                        <a href="/register-student"
                            class="inline-flex justify-center items-center rounded-2xl bg-indigo-600 px-8 py-4 text-base font-semibold text-white shadow-xl shadow-indigo-600/20 hover:bg-indigo-500 hover:shadow-indigo-500/30 transition-all duration-300 hover:-translate-y-1">
                            Daftar Sekarang
                            <svg class="ml-2 -mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" width="20"
                                height="20">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#features"
                            class="inline-flex justify-center items-center rounded-2xl bg-white px-8 py-4 text-base font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 transition-all duration-300">
                            Info PPDB
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-16 sm:mt-24 lg:col-span-6 lg:mt-0">
                @php
                    $heroImages = \App\Models\HeroImage::where('is_active', true)->latest()->get();
                @endphp

                <div class="relative sm:mx-auto sm:max-w-lg lg:max-w-none lg:mx-0">
                    <div class="relative w-full rounded-3xl shadow-2xl overflow-hidden ring-1 ring-slate-900/10">
                        @if($heroImages->isNotEmpty())
                            <div x-data="{
                                currentSlide: 0,
                                totalSlides: {{ $heroImages->count() }},
                                autoplay: null,
                                init() {
                                    this.autoplay = setInterval(() => {
                                        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                                    }, 4000);
                                },
                                goTo(index) {
                                    this.currentSlide = index;
                                    clearInterval(this.autoplay);
                                    this.autoplay = setInterval(() => {
                                        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                                    }, 4000);
                                }
                            }" class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                @foreach($heroImages as $index => $heroImage)
                                    <div x-show="currentSlide === {{ $index }}"
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 transform scale-105"
                                         x-transition:enter-end="opacity-100 transform scale-100"
                                         x-transition:leave="transition ease-in duration-300"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="absolute inset-0">
                                        <img src="{{ asset('storage/' . $heroImage->image) }}"
                                             alt="{{ $heroImage->alt_text ?? 'TK Puspitasari' }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @endforeach

                                {{-- Slide indicators --}}
                                @if($heroImages->count() > 1)
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                                        @foreach($heroImages as $index => $heroImage)
                                            <button @click="goTo({{ $index }})"
                                                    :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 w-2'"
                                                    class="h-2 rounded-full transition-all duration-300 hover:bg-white/80"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="aspect-[4/3] bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 flex items-center justify-center relative overflow-hidden">
                                <svg class="absolute w-full h-full text-indigo-500/10" fill="currentColor"
                                    viewBox="0 0 100 100" preserveAspectRatio="none" width="100%" height="100%">
                                    <polygon points="0,100 100,0 100,100" />
                                </svg>
                                <div class="z-10 text-center">
                                    <div class="w-24 h-24 mx-auto bg-white/60 backdrop-blur-md rounded-full shadow-lg flex items-center justify-center mb-6 ring-1 ring-white/50">
                                        <span class="text-4xl">🎨</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Play, Learn, Grow</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="features" class="py-24 bg-slate-50 border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Keunggulan Kami</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl">Program Unggulan TK Puspitasari</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-slate-200/50 hover:shadow-xl hover:ring-emerald-100 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 ring-1 ring-emerald-100">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="28" height="28">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Hafalan Nadzhom Asmaul Husna</h3>
                <p class="text-slate-600 leading-relaxed">Menanamkan nilai-nilai keislaman sejak dini melalui metode hafalan Asmaul Husna yang menyenangkan dan mudah diingat oleh anak-anak.</p>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-slate-200/50 hover:shadow-xl hover:ring-blue-100 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-6 ring-1 ring-blue-100">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="28" height="28">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Hafalan Surat-Surat Pendek</h3>
                <p class="text-slate-600 leading-relaxed">Membiasakan ananda mencintai Al-Quran dengan program hafalan surat-surat pendek (Juz'amma) setiap harinya.</p>
            </div>
        </div>
    </div>
</div>

<div id="info-ppdb" class="py-24 bg-white border-t border-slate-200/60 relative overflow-hidden">
    {{-- Decorative background shapes --}}
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3">
        <div class="w-96 h-96 bg-yellow-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    </div>
    <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3">
        <div class="w-96 h-96 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-base font-semibold text-red-600 tracking-wide uppercase">Informasi PPDB</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl">Penerimaan Peserta Didik Baru</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Syarat Pendaftaran --}}
            <div class="bg-gradient-to-b from-white to-slate-50 rounded-3xl p-8 shadow-lg shadow-slate-200/40 ring-1 ring-slate-200">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4">Syarat Pendaftaran</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600">Fotocopy Akte Kelahiran</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600">Fotocopy Kartu Keluarga (KK)</span>
                    </li>
                </ul>
            </div>

            {{-- Waktu Pendaftaran --}}
            <div class="bg-gradient-to-b from-yellow-50 to-orange-50 rounded-3xl p-8 shadow-lg shadow-yellow-100/40 ring-1 ring-yellow-200/50 transform md:-translate-y-4">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4">Waktu Pendaftaran</h3>
                <div class="bg-white rounded-2xl p-4 shadow-sm mb-4 ring-1 ring-slate-100">
                    <p class="font-bold text-yellow-600 text-lg text-center">24 Juni - 17 Juli {{ date('Y') }}</p>
                </div>
                <p class="text-slate-600 flex items-start mt-4">
                    <svg class="w-5 h-5 text-slate-400 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span>Datang Langsung ke Kantor TK Puspitasari Kaliwatubumi</span>
                </p>
            </div>

            {{-- Contact Person --}}
            <div class="bg-gradient-to-b from-white to-slate-50 rounded-3xl p-8 shadow-lg shadow-slate-200/40 ring-1 ring-slate-200">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4">Contact Person</h3>
                <div class="space-y-4">
                    <a href="https://wa.me/6285328209910" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 ring-1 ring-slate-200 hover:ring-emerald-200 transition-all group">
                        <div>
                            <p class="font-bold text-slate-800">Ibu Kotijah</p>
                            <p class="text-sm text-slate-500">0853-2820-9910</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors text-emerald-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </div>
                    </a>
                    <a href="https://wa.me/6282312474292" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 ring-1 ring-slate-200 hover:ring-emerald-200 transition-all group">
                        <div>
                            <p class="font-bold text-slate-800">Ibu Sukowati</p>
                            <p class="text-sm text-slate-500">0823-1247-4292</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors text-emerald-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection