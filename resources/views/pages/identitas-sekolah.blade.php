@extends('layouts.app')

@section('title', 'Identitas Sekolah — TK Puspitasari Kaliwatubumi')

@section('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Striped table rows */
        .identity-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .identity-table tr:hover {
            background-color: #f0fdf4;
            transition: background .2s;
        }
    </style>
@endsection

@section('content')

    {{-- ===== PAGE HEADER BANNER ===== --}}
    <div style="background-color:#4CAF93;" class="w-full py-10">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-2xl font-bold text-white mb-1">Identitas Sekolah</h1>
            <nav class="text-sm text-white/80 flex items-center gap-1">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <span class="mx-1">/</span>
                <a href="/profil-sekolah" class="hover:text-white transition-colors">Profil Kami</a>
                <span class="mx-1">/</span>
                <span class="text-white font-medium">Identitas Sekolah</span>
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
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 lg:p-10">
                        <h2 class="text-2xl font-bold text-gray-900 pb-4 mb-6 border-b border-gray-100">
                            Identitas Sekolah
                        </h2>

                        @php
                            $schoolName = $identity?->school_name ?? 'TK PUSPITASARI';
                            $npsn = $identity?->npsn ?? '-';
                            $status = $identity?->status ?? 'Swasta';
                            $educationForm = $identity?->education_form ?? 'TK';
                            $ownershipStatus = $identity?->ownership_status ?? 'Yayasan';
                            $estDecree = $identity?->establishment_decree ?? '-';
                            $estDate = $identity?->establishment_date ? $identity->establishment_date->format('d-m-Y') : '-';
                            $opDecree = $identity?->operational_decree ?? '-';
                            $opDate = $identity?->operational_date ? $identity->operational_date->format('d-m-Y') : '-';
                            $address = $identity?->address ?? 'Kaliwatubumi';
                            $hamlet = $identity?->hamlet ?? '-';
                            $village = $identity?->village ?? 'Kaliwatubumi';
                            $district = $identity?->district ?? 'Butuh';
                            $regency = $identity?->regency ?? 'Purworejo';
                            $province = $identity?->province ?? 'Jawa Tengah';
                            $postalCode = $identity?->postal_code ?? '-';

                            $naungan = $identity?->naungan ?? '-';
                            $accreditation = $identity?->accreditation ?? '-';
                            $accDate = $identity?->accreditation_date ? $identity->accreditation_date->format('d-m-Y') : '-';
                            $accDecree = $identity?->accreditation_decree ?? '-';
                            $certification = $identity?->certification ?? '-';
                            $phone = $identity?->phone ?? '-';
                            $email = $identity?->email ?? '-';
                            $website = $identity?->website ?? '-';
                            $headmaster = $identity?->headmaster ?? '-';
                            $operator = $identity?->operator ?? '-';
                        @endphp

                        {{-- Table 1: Dokumen & Status Resmi --}}
                        <div class="mb-8">
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                                <i class="bi bi-file-earmark-text-fill" style="color:#4CAF93;"></i>
                                Profil & Status Resmi
                            </p>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="identity-table w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700 w-2/5">Nama Sekolah</td>
                                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $schoolName }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">NPSN</td>
                                            <td class="px-4 py-3 text-gray-800 font-mono">{{ $npsn }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Naungan</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $naungan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Bentuk Pendidikan</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $educationForm }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Status Sekolah</td>
                                            <td class="px-4 py-3 text-gray-800">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Status Kepemilikan</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $ownershipStatus }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">SK Pendirian Sekolah</td>
                                            <td class="px-4 py-3 text-gray-800 font-mono text-xs">{{ $estDecree }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Tanggal SK Pendirian</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $estDate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">SK Izin Operasional</td>
                                            <td class="px-4 py-3 text-gray-800 font-mono text-xs">{{ $opDecree }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Tanggal SK Izin Operasional</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $opDate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Akreditasi</td>
                                            <td class="px-4 py-3 text-gray-800">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $accreditation }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">SK Akreditasi</td>
                                            <td class="px-4 py-3 text-gray-800 font-mono text-xs">{{ $accDecree }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Tanggal Akreditasi</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $accDate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Sertifikasi</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $certification }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Table 2: Alamat Sekolah --}}
                        <div class="mb-8">
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                                <i class="bi bi-geo-alt-fill" style="color:#4CAF93;"></i>
                                Alamat & Lokasi
                            </p>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="identity-table w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700 w-2/5">Alamat</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Dusun</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $hamlet }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Desa/Kelurahan</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $village }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Kecamatan</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $district }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Kabupaten</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $regency }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Provinsi</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $province }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Kode Pos</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $postalCode }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Table 3: Kontak & Pengelola --}}
                        <div>
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                                <i class="bi bi-person-badge-fill" style="color:#4CAF93;"></i>
                                Kontak & Pengelola
                            </p>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="identity-table w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700 w-2/5">No Telepon</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Email</td>
                                            <td class="px-4 py-3 text-gray-800">
                                                @if($email !== '-')
                                                    <a href="mailto:{{ $email }}" class="text-green-700 hover:underline">{{ $email }}</a>
                                                @else
                                                    {{ $email }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Website</td>
                                            <td class="px-4 py-3 text-gray-800">
                                                @if($website !== '-')
                                                    <a href="{{ $website }}" target="_blank" class="text-green-700 hover:underline">{{ $website }}</a>
                                                @else
                                                    {{ $website }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Kepala Sekolah</td>
                                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $headmaster }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold text-gray-700">Operator</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $operator }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if(!$identity)
                            <div class="mt-6 p-4 rounded-xl border border-yellow-200 bg-yellow-50 flex items-center gap-3">
                                <i class="bi bi-exclamation-triangle-fill text-yellow-500"></i>
                                <p class="text-sm text-yellow-700">
                                    Data identitas sekolah belum diisi. Data di atas adalah data default.
                                    <a href="/admin" class="font-semibold underline hover:text-yellow-900">Isi melalui Admin Panel →</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </main>

            {{-- ============================= --}}
            {{-- RIGHT COLUMN (1/3) — Sidebar --}}
            {{-- ============================= --}}
            <aside class="w-full lg:w-1/3 flex flex-col gap-6">

                {{-- Widget 1: Agenda Mendatang --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-2 px-5 py-4" style="background-color:#4CAF93;">
                        <i class="bi bi-calendar-event text-white"></i>
                        <h2 class="text-base font-bold text-white">Agenda Mendatang</h2>
                    </div>
                    <ul class="divide-y divide-gray-50">
                        @php
                            $upcomingAgendas = \App\Models\Agenda::whereDate('event_date', '>=', now())->orderBy('event_date', 'asc')->take(4)->get();
                        @endphp
                        @forelse($upcomingAgendas as $agenda)
                            <li>
                                <a href="/agenda" class="flex items-start gap-3 px-5 py-4 hover:bg-green-50 transition-colors group">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex flex-col items-center justify-center border border-gray-100 bg-white shadow-sm group-hover:border-green-200 transition-colors">
                                        <span class="text-xs font-bold text-gray-500 uppercase leading-none">{{ \Carbon\Carbon::parse($agenda->event_date)->translatedFormat('M') }}</span>
                                        <span class="text-lg font-bold text-green-600 leading-none mt-1">{{ \Carbon\Carbon::parse($agenda->event_date)->translatedFormat('d') }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-0.5">
                                        <p class="text-sm font-semibold text-gray-800 leading-snug group-hover:text-green-700 transition-colors line-clamp-2">
                                            {{ $agenda->title }}
                                        </p>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="px-5 py-6 text-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background-color:#E8F5F1;">
                                    <i class="bi bi-calendar-x text-xl" style="color:#4CAF93;"></i>
                                </div>
                                <p class="text-sm text-gray-500">Belum ada agenda terdekat.</p>
                            </li>
                        @endforelse
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
                                    <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                        @if($article->image)
                                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center"
                                                style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                                <i class="bi bi-newspaper text-white text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-medium text-gray-800 leading-snug group-hover:text-green-700 transition-colors line-clamp-2">
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
                            @foreach([
                                        ['Kegiatan Outing Class Siswa TK Puspitasari', '8 Maret 2025'],
                                        ['Program Hafalan Asmaul Husna Semester 2', '15 Februari 2025'],
                                        ['Peringatan Hari Pendidikan Nasional 2025', '3 Januari 2025'],
                                        ['Pentas Seni & Perpisahan Semester 1', '20 Desember 2024'],
                                    ] as [$judul, $tgl])
                                    <li>
                                        <a href="#" class="flex gap-3 px-5 py-4 hover:bg-green-50 transition-colors group">
                                            <div class="flex-shrink-0 w-16 h-16 rounded-xl flex items-center justify-center"
                                                 style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                                                <i class="bi bi-newspaper text-white text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 leading-snug group-hover:text-green-700 transition-colors line-clamp-2">
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

                {{-- Widget 3: PSB CTA --}}
                <div class="rounded-2xl overflow-hidden shadow-sm p-8 text-center text-white"
                     style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                         <i class="bi bi-mortarboard-fill text-3xl text-white"></i>
                     </div>
                    <h3 class="text-xl font-bold mb-1">PSB {{ date('Y') }}/{{ date('Y') + 1 }}</h3>
                    <p class="text-sm text-white/80 mb-5">Daftarkan putra-putri Anda sekarang!</p>
                    <a href="{{ route('ppdb.user.index') }}"
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
