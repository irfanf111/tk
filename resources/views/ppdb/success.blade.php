<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil – PPDB TK Puspitasari</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: linear-gradient(135deg, #0f0c29, #302b63, #24243e); min-height: 100vh; }
    </style>
</head>
<body class="font-['Inter'] text-slate-200 antialiased flex items-center justify-center min-h-screen px-4 py-12">
    <div class="max-w-lg w-full bg-[#1e1b4b]/90 border border-indigo-800/50 rounded-2xl shadow-2xl p-8 text-center">

        {{-- Checkmark Icon --}}
        <div class="w-20 h-20 rounded-full bg-emerald-500/20 border-2 border-emerald-400 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-white mb-2">Pendaftaran Berhasil!</h1>
        <p class="text-indigo-300 text-sm mb-6">Data pendaftaran Anda telah kami terima dan sedang dalam proses verifikasi.</p>

        {{-- No. Pendaftaran --}}
        <div class="bg-[#2d2a5e] border border-indigo-700 rounded-xl px-6 py-4 mb-6">
            <p class="text-xs text-indigo-400 mb-1">Nomor Pendaftaran Anda</p>
            <p class="text-2xl font-bold text-indigo-200 tracking-widest">
                {{ $registration->nomor_pendaftaran ?? $registration->no_pendaftaran }}
            </p>
            <p class="text-xs text-indigo-500 mt-1">Simpan nomor ini sebagai bukti pendaftaran</p>
        </div>

        {{-- Info Siswa --}}
        <div class="text-left space-y-2 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-indigo-400">Nama Siswa</span>
                <span class="font-semibold text-white">{{ $registration->nama_terpadu }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-indigo-400">Status</span>
                <span class="bg-amber-500/20 text-amber-300 border border-amber-500/40 px-3 py-0.5 rounded-full text-xs font-semibold">
                    Menunggu Verifikasi
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-indigo-400">Tanggal Daftar</span>
                <span class="font-medium text-slate-300">{{ $registration->created_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('ppdb.pdf', $registration->id) }}"
               class="flex-1 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white text-sm font-semibold transition-all text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Unduh Bukti PDF
            </a>
            <a href="{{ url('/') }}"
               class="flex-1 py-3 rounded-xl border border-indigo-700 text-indigo-300 text-sm font-medium hover:bg-indigo-900/40 transition text-center">
                Ke Beranda
            </a>
        </div>

    </div>
</body>
</html>
