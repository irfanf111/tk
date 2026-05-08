<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PPDB – TK Puspitasari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f4f7f6; min-height: 100vh; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #4CAF93; border-radius: 3px; }
    </style>
</head>
<body class="font-['Inter'] antialiased text-gray-800">

{{-- ── NAV ── --}}
<nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-3xl mx-auto px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center shadow-md flex-shrink-0" style="background-color:#4CAF93;">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-gray-800 text-sm leading-tight">Portal PPDB</p>
            <p class="text-xs truncate" style="color:#4CAF93;">TK Puspitasari · Halo, {{ auth()->user()->name }}</p>
        </div>
        <div class="flex items-center gap-2 ml-auto">
            <a href="{{ url('/') }}" class="text-xs text-gray-500 hover:text-gray-800 transition hidden sm:block">← Beranda</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 transition font-medium">Keluar</button>
            </form>
        </div>
    </div>
</nav>

<main class="max-w-3xl mx-auto px-4 py-8">

    {{-- ── SESSION ALERTS ── --}}
    @if(session('success'))
    <div class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 text-sm shadow-sm">
        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <p class="leading-relaxed">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm shadow-sm">
        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <p class="leading-relaxed">{{ session('error') }}</p>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════
         CARD UTAMA
    ═══════════════════════════════════════════════ --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden">

        {{-- Header Card --}}
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-lg font-bold text-gray-800">Status Pendaftaran PPDB</h1>
                <p class="text-xs text-gray-500 mt-0.5">Penerimaan Peserta Didik Baru · TK Puspitasari</p>
            </div>

            {{-- Status Badge --}}
            @php
                $status = $registration?->status;
                $badgeMap = [
                    'draft'        => ['label' => 'Draft',                'cls' => 'bg-gray-100 text-gray-600 border-gray-300'],
                    'submitted'    => ['label' => 'Menunggu Verifikasi',   'cls' => 'bg-yellow-50 text-yellow-700 border-yellow-300'],
                    'pending'      => ['label' => 'Menunggu Verifikasi',   'cls' => 'bg-yellow-50 text-yellow-700 border-yellow-300'],
                    'verified'     => ['label' => 'Berkas Valid',          'cls' => 'bg-blue-50 text-blue-700 border-blue-300'],
                    'accepted'     => ['label' => 'Diterima ✓',           'cls' => 'bg-green-50 text-green-700 border-green-300'],
                    'rejected'     => ['label' => 'Perlu Revisi',         'cls' => 'bg-red-50 text-red-700 border-red-300'],
                    'not_accepted' => ['label' => 'Tidak Diterima',       'cls' => 'bg-red-50 text-red-700 border-red-300'],
                ];
                $badge = $badgeMap[$status] ?? null;
            @endphp

            @if($badge)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $badge['cls'] }} self-start sm:self-auto">
                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                {{ $badge['label'] }}
            </span>
            @endif
        </div>

        {{-- Body --}}
        <div class="px-6 py-8">

            {{-- ── BELUM MENDAFTAR ── --}}
            @if(!$registration)
            <div class="text-center py-6">
                <div class="w-20 h-20 rounded-2xl mx-auto mb-5 flex items-center justify-center" style="background: linear-gradient(135deg,#e8f5f0,#c8ead9);">
                    <svg class="w-10 h-10" style="color:#4CAF93;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                <p class="text-gray-500 text-sm max-w-sm mx-auto mb-7 leading-relaxed">
                    Anda belum mengisi formulir pendaftaran. Silakan mulai dengan mengisi data diri, data orang tua, dan upload dokumen pendukung.
                </p>
                <a href="{{ route('ppdb.user.create') }}"
                   class="inline-flex items-center gap-2 px-7 py-3 rounded-xl text-white text-sm font-semibold shadow-lg transition-all hover:opacity-90 active:scale-95"
                   style="background: linear-gradient(135deg,#4CAF93,#3b9a7a); box-shadow: 0 4px 14px rgba(76,175,147,.4);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Mulai Isi Formulir
                </a>
            </div>

            {{-- ── SUDAH MENDAFTAR ── --}}
            @else

            {{-- Info Siswa --}}
            @if($student)
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-bold text-lg" style="background-color:#4CAF93;">
                    {{ strtoupper(substr($student->nama_lengkap, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 truncate">{{ $student->nama_lengkap }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        @if($student->tempat_lahir && $student->tanggal_lahir)
                         · {{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d M Y') }}
                        @endif
                    </p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-lg bg-white border border-gray-200 text-gray-500 font-medium hidden sm:block">
                    Terdaftar
                </span>
            </div>
            @endif

            {{-- ── CATATAN ADMIN (untuk status rejected/not_accepted) ── --}}
            @if($registration->notes && in_array($status, ['rejected','not_accepted']))
            <div class="mb-6 flex gap-3 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 mb-1">Alasan dari Panitia PPDB:</p>
                    <p class="text-sm text-red-600 leading-relaxed">{{ $registration->notes }}</p>
                </div>
            </div>
            @endif

            {{-- ── KONTEN PER STATUS ── --}}

            {{-- DRAFT --}}
            @if($status === 'draft')
            <div class="text-center py-4">
                <div class="w-16 h-16 rounded-xl mx-auto mb-4 flex items-center justify-center bg-gray-100">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h2 class="font-bold text-gray-700 mb-1">Formulir Belum Dikirim</h2>
                <p class="text-sm text-gray-500 max-w-xs mx-auto mb-6 leading-relaxed">
                    Data Anda sudah tersimpan sebagai draft. Lengkapi formulir dan upload dokumen, lalu kirim pendaftaran Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('ppdb.user.edit') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold border-2 transition-all hover:bg-gray-50 active:scale-95"
                       style="border-color:#4CAF93; color:#4CAF93;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Lanjutkan Pengisian
                    </a>
                    <form action="{{ route('ppdb.user.submit') }}" method="POST" class="m-0"
                          onsubmit="return confirm('Pastikan semua data dan dokumen sudah lengkap. Setelah dikirim, data tidak dapat diubah. Lanjutkan?')">
                        @csrf
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white text-sm font-semibold shadow-md transition-all hover:opacity-90 active:scale-95"
                            style="background: linear-gradient(135deg,#4CAF93,#3b9a7a);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Pendaftaran
                        </button>
                    </form>
                </div>
            </div>

            {{-- SUBMITTED / PENDING --}}
            @elseif(in_array($status, ['submitted','pending']))
            <div class="text-center py-4">
                <div class="w-16 h-16 rounded-xl mx-auto mb-4 flex items-center justify-center bg-yellow-50">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="inline-block mb-3 px-4 py-1.5 rounded-full text-xs font-bold border bg-yellow-50 text-yellow-700 border-yellow-300">⏳ Menunggu Verifikasi Admin</span>
                <h2 class="font-bold text-gray-700 mb-1">Pendaftaran Sedang Diproses</h2>
                <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                    Data dan dokumen Anda telah berhasil dikirim. Panitia PPDB sedang meninjau berkas Anda. Pantau halaman ini untuk pembaruan status.
                </p>
                @if($registration->notes)
                <div class="mt-5 text-left bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold text-blue-700 mb-1">Catatan Admin:</p>
                    <p class="text-sm text-blue-600">{{ $registration->notes }}</p>
                </div>
                @endif
            </div>

            {{-- VERIFIED --}}
            @elseif($status === 'verified')
            <div class="text-center py-4">
                <div class="w-16 h-16 rounded-xl mx-auto mb-4 flex items-center justify-center bg-blue-50">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="inline-block mb-3 px-4 py-1.5 rounded-full text-xs font-bold border bg-blue-50 text-blue-700 border-blue-300">🛡️ Berkas Valid</span>
                <h2 class="font-bold text-gray-700 mb-1">Berkas Telah Diverifikasi</h2>
                <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                    Berkas pendaftaran Anda telah dinyatakan valid oleh panitia. Harap tunggu pengumuman penerimaan resmi.
                </p>
                @if($registration->notes)
                <div class="mt-5 text-left bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold text-blue-700 mb-1">Catatan Admin:</p>
                    <p class="text-sm text-blue-600">{{ $registration->notes }}</p>
                </div>
                @endif
            </div>

            {{-- ACCEPTED --}}
            @elseif($status === 'accepted')
            <div class="text-center py-4">
                <div class="w-20 h-20 rounded-2xl mx-auto mb-5 flex items-center justify-center" style="background: linear-gradient(135deg,#e8f5f0,#c8ead9);">
                    <svg class="w-10 h-10" style="color:#4CAF93;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span class="inline-block mb-3 px-4 py-1.5 rounded-full text-xs font-bold border" style="background:#e8f5f0; color:#2d7a5a; border-color:#a7d9c4;">🎉 Selamat! Diterima</span>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Selamat, Anda Diterima!</h2>
                <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                    Pendaftaran <strong class="text-gray-700">{{ $student?->nama_lengkap }}</strong> telah diterima di TK Puspitasari. Silakan hubungi pihak sekolah untuk informasi selanjutnya mengenai daftar ulang.
                </p>
                @if($registration->notes)
                <div class="mt-5 text-left bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold text-green-700 mb-1">Pesan dari Admin:</p>
                    <p class="text-sm text-green-600">{{ $registration->notes }}</p>
                </div>
                @endif
            </div>

            {{-- REJECTED / NOT_ACCEPTED --}}
            @elseif(in_array($status, ['rejected','not_accepted']))
            <div class="text-center py-4">
                <div class="w-16 h-16 rounded-xl mx-auto mb-4 flex items-center justify-center bg-red-50">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="inline-block mb-3 px-4 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-300">
                    {{ $status === 'rejected' ? '⚠ Perlu Revisi' : '✕ Tidak Diterima' }}
                </span>
                <h2 class="font-bold text-gray-700 mb-1">
                    {{ $status === 'rejected' ? 'Pendaftaran Memerlukan Perbaikan' : 'Pendaftaran Tidak Diterima' }}
                </h2>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6 leading-relaxed">
                    {{ $status === 'rejected'
                        ? 'Panitia PPDB meminta Anda untuk memperbaiki data atau dokumen. Silakan baca catatan di bawah dan edit formulir Anda.'
                        : 'Kami mohon maaf, pendaftaran Anda tidak dapat kami terima pada periode ini.' }}
                </p>
                @if($status === 'rejected')
                <a href="{{ route('ppdb.user.edit') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white shadow-md transition-all hover:opacity-90 active:scale-95"
                   style="background: linear-gradient(135deg,#ef4444,#dc2626);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit &amp; Perbaiki Formulir
                </a>
                @endif
            </div>

            @endif {{-- end status --}}

            @endif {{-- end $registration --}}

        </div>{{-- end card body --}}

    </div>{{-- end card --}}

    {{-- ── INFO KONTAK ── --}}
    <div class="mt-5 text-center">
        <p class="text-xs text-gray-400">
            Butuh bantuan? Hubungi TK Puspitasari melalui WhatsApp atau datang langsung ke sekolah.
        </p>
    </div>

</main>

{{-- ── SweetAlert2: Notifikasi Session ── --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            html: '<p style="font-size:15px;color:#555;line-height:1.6">{{ session("success") }}</p>',
            confirmButtonText: 'Oke, Mengerti',
            confirmButtonColor: '#4CAF93',
            showClass: { popup: 'animate__animated animate__fadeInDown' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp' },
            timer: 8000,
            timerProgressBar: true,
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: '<p style="font-size:15px;color:#555;line-height:1.6">{{ session("error") }}</p>',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#ef4444',
        });
    });
</script>
@endif

</body>
</html>
