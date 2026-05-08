<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input LPAD – TK Puspitasari</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- TailwindCSS CDN (Play CDN for development) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary:  { DEFAULT: '#4f46e5', light: '#818cf8', dark: '#3730a3' },
                        surface:  '#1e1b4b',
                        card:     '#2d2a5e',
                        border:   '#4338ca',
                    }
                }
            }
        }
    </script>

    {{-- CKEditor 5 (CDN) --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <style>
        body { background: linear-gradient(135deg, #0f0c29, #302b63, #24243e); min-height: 100vh; }

        /* CKEditor dark-compat */
        .ck-editor__editable { min-height: 160px !important; background: #1e1b4b !important; color: #e0e7ff !important; border-color: #4338ca !important; border-radius: 0.5rem !important; }
        .ck-toolbar { background: #2d2a5e !important; border-color: #4338ca !important; border-radius: 0.5rem 0.5rem 0 0 !important; }
        .ck-toolbar .ck-button { color: #c7d2fe !important; }
        .ck-toolbar .ck-button:hover { background: #4338ca !important; }
        .ck.ck-editor { border-radius: 0.5rem !important; overflow: hidden; border: 1px solid #4338ca !important; }
        .ck-focused { border-color: #818cf8 !important; box-shadow: 0 0 0 3px rgba(129,140,248,.25) !important; }

        /* custom scrollbar */
        ::-webkit-scrollbar { width: 8px; } ::-webkit-scrollbar-track { background: #1e1b4b; } ::-webkit-scrollbar-thumb { background: #4338ca; border-radius: 4px; }

        /* input focus glow */
        input:focus, select:focus, textarea:focus { outline: none; box-shadow: 0 0 0 3px rgba(129,140,248,.35); }

        /* section card animation */
        .section-card { transition: box-shadow .2s; }
        .section-card:hover { box-shadow: 0 8px 30px rgba(79,70,229,.35); }
    </style>
</head>
<body class="font-sans text-slate-200 antialiased">

{{-- ── TOP NAV ──────────────────────────────────────────────────────── --}}
<nav class="sticky top-0 z-50 bg-[#1a1740]/80 backdrop-blur-md border-b border-indigo-900/50 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/40">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-white leading-tight">LPAD TK Puspitasari</h1>
            <p class="text-xs text-indigo-300">Laporan Perkembangan Anak Didik · Kurikulum Merdeka</p>
        </div>
    </div>
</nav>

{{-- ── MAIN ─────────────────────────────────────────────────────────── --}}
<main class="max-w-5xl mx-auto px-4 py-10">

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div id="alert-success"
         class="mb-6 flex items-center gap-3 bg-emerald-900/50 border border-emerald-500/60 text-emerald-300 rounded-xl px-5 py-4 shadow-lg animate-pulse">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Alert Error Validasi --}}
    @if($errors->any())
    <div class="mb-6 bg-rose-900/50 border border-rose-500/60 text-rose-300 rounded-xl px-5 py-4 shadow-lg">
        <p class="font-semibold mb-2">⚠ Terdapat kesalahan pada form:</p>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" id="lpad-form" novalidate>
        @csrf

        {{-- ══════════════════════════════════════════════════════════
             SECTION 1: IDENTITAS SISWA
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-sm font-bold text-white shadow">1</div>
                <h2 class="text-lg font-semibold text-indigo-200">Identitas Siswa & Periode Laporan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Pilih Siswa --}}
                <div class="md:col-span-2">
                    <label for="lpad_student_id" class="block text-sm font-medium text-indigo-300 mb-2">
                        Nama Siswa <span class="text-rose-400">*</span>
                    </label>
                    <select id="lpad_student_id" name="lpad_student_id" required
                        class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm transition focus:border-indigo-400">
                        <option value="">— Pilih Siswa —</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('lpad_student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->nama_lengkap }} ({{ $student->no_induk }})
                            </option>
                        @endforeach
                    </select>
                    @error('lpad_student_id')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Tahun Ajaran --}}
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-indigo-300 mb-2">
                        Tahun Ajaran <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                        value="{{ old('tahun_ajaran', '2025/2026') }}"
                        placeholder="cth: 2025/2026" required
                        class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm transition focus:border-indigo-400">
                    @error('tahun_ajaran')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Semester --}}
                <div>
                    <label for="semester" class="block text-sm font-medium text-indigo-300 mb-2">
                        Semester <span class="text-rose-400">*</span>
                    </label>
                    <select id="semester" name="semester" required
                        class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm transition focus:border-indigo-400">
                        <option value="">— Pilih Semester —</option>
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                    @error('semester')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SECTION 2: DATA FISIK
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-violet-600 flex items-center justify-center text-sm font-bold text-white shadow">2</div>
                <h2 class="text-lg font-semibold text-indigo-200">Data Fisik & Antropometri</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                @php
                    $fisikFields = [
                        ['name' => 'bb',             'label' => 'Berat Badan (kg)',     'placeholder' => 'cth: 18.5'],
                        ['name' => 'tb',             'label' => 'Tinggi Badan (cm)',    'placeholder' => 'cth: 110.0'],
                        ['name' => 'lingkar_kepala', 'label' => 'Lingkar Kepala (cm)', 'placeholder' => 'cth: 52.0'],
                    ];
                @endphp

                @foreach($fisikFields as $field)
                <div>
                    <label for="{{ $field['name'] }}" class="block text-sm font-medium text-indigo-300 mb-2">
                        {{ $field['label'] }} <span class="text-rose-400">*</span>
                    </label>
                    <input type="number" step="0.1" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                        value="{{ old($field['name']) }}"
                        placeholder="{{ $field['placeholder'] }}" required
                        class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm transition focus:border-indigo-400">
                    @error($field['name'])<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                @endforeach

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SECTION 3: KONDISI KESEHATAN
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-teal-600 flex items-center justify-center text-sm font-bold text-white shadow">3</div>
                <h2 class="text-lg font-semibold text-indigo-200">Kondisi Kesehatan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @php
                    $kesehatanFields = [
                        ['name' => 'kondisi_mata',    'label' => 'Kondisi Mata'],
                        ['name' => 'kondisi_telinga', 'label' => 'Kondisi Telinga'],
                        ['name' => 'kondisi_hidung',  'label' => 'Kondisi Hidung'],
                        ['name' => 'kondisi_gigi',    'label' => 'Kondisi Gigi'],
                        ['name' => 'kondisi_kulit',   'label' => 'Kondisi Kulit'],
                    ];
                    $kesehatanOptions = ['Baik', 'Cukup', 'Perlu Perhatian', 'Dalam Pengobatan'];
                @endphp

                @foreach($kesehatanFields as $kField)
                <div>
                    <label for="{{ $kField['name'] }}" class="block text-sm font-medium text-indigo-300 mb-2">
                        {{ $kField['label'] }} <span class="text-rose-400">*</span>
                    </label>
                    <select id="{{ $kField['name'] }}" name="{{ $kField['name'] }}" required
                        class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm transition focus:border-indigo-400">
                        <option value="">— Pilih —</option>
                        @foreach($kesehatanOptions as $opt)
                            <option value="{{ $opt }}" {{ old($kField['name']) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error($kField['name'])<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                @endforeach

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SECTION 4: KEHADIRAN
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-amber-600 flex items-center justify-center text-sm font-bold text-white shadow">4</div>
                <h2 class="text-lg font-semibold text-indigo-200">Rekap Kehadiran</h2>
            </div>

            <div class="grid grid-cols-3 gap-5">
                @foreach([['sakit','Sakit (hari)','🤒'],['izin','Izin (hari)','📝'],['alpa','Alpa (hari)','❌']] as [$fname,$flabel,$emoji])
                <div class="bg-[#2d2a5e]/60 rounded-xl p-4 text-center border border-indigo-800/50">
                    <div class="text-2xl mb-2">{{ $emoji }}</div>
                    <label for="{{ $fname }}" class="block text-xs font-medium text-indigo-300 mb-2">{{ $flabel }}</label>
                    <input type="number" min="0" id="{{ $fname }}" name="{{ $fname }}"
                        value="{{ old($fname, 0) }}" required
                        class="w-full bg-[#1e1b4b] border border-indigo-700 rounded-lg px-3 py-2 text-center text-slate-200 text-sm font-semibold transition focus:border-indigo-400">
                    @error($fname)<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                @endforeach
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SECTION 5: NARASI CAPAIAN PEMBELAJARAN (CKEditor)
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-rose-600 flex items-center justify-center text-sm font-bold text-white shadow">5</div>
                <h2 class="text-lg font-semibold text-indigo-200">Narasi Capaian Pembelajaran</h2>
                <span class="text-xs text-indigo-400 ml-auto bg-indigo-900/50 px-3 py-1 rounded-full">Rich Text Editor aktif</span>
            </div>

            <div class="space-y-6">

                {{-- Elemen Agama & Budi Pekerti --}}
                <div>
                    <label class="block text-sm font-semibold text-indigo-300 mb-2">
                        📖 Elemen Agama &amp; Budi Pekerti
                    </label>
                    <textarea id="elemen_agama_budi_pekerti" name="elemen_agama_budi_pekerti" class="ck-editor-field">{{ old('elemen_agama_budi_pekerti') }}</textarea>
                    @error('elemen_agama_budi_pekerti')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Elemen Jati Diri --}}
                <div>
                    <label class="block text-sm font-semibold text-indigo-300 mb-2">
                        🌱 Elemen Jati Diri
                    </label>
                    <textarea id="elemen_jati_diri" name="elemen_jati_diri" class="ck-editor-field">{{ old('elemen_jati_diri') }}</textarea>
                    @error('elemen_jati_diri')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Elemen Literasi & STEAM --}}
                <div>
                    <label class="block text-sm font-semibold text-indigo-300 mb-2">
                        🔬 Elemen Literasi &amp; STEAM
                    </label>
                    <textarea id="elemen_literasi_steam" name="elemen_literasi_steam" class="ck-editor-field">{{ old('elemen_literasi_steam') }}</textarea>
                    @error('elemen_literasi_steam')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Projek P5 --}}
                <div>
                    <label class="block text-sm font-semibold text-indigo-300 mb-2">
                        🚀 Projek Penguatan Profil Pelajar Pancasila (P5)
                    </label>
                    <textarea id="projek_p5" name="projek_p5" class="ck-editor-field">{{ old('projek_p5') }}</textarea>
                    @error('projek_p5')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SECTION 6: KOMENTAR ORANG TUA
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="section-card bg-[#1e1b4b]/80 border border-indigo-800/60 backdrop-blur-sm rounded-2xl p-7 mb-8 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-sky-600 flex items-center justify-center text-sm font-bold text-white shadow">6</div>
                <h2 class="text-lg font-semibold text-indigo-200">Komentar / Harapan Orang Tua</h2>
                <span class="text-xs text-indigo-400 ml-auto">(Opsional)</span>
            </div>
            <textarea id="komentar_ortu" name="komentar_ortu" rows="4"
                placeholder="Tulis komentar atau harapan dari orang tua/wali siswa di sini..."
                class="w-full bg-[#2d2a5e] border border-indigo-700 rounded-xl px-4 py-3 text-slate-200 text-sm resize-y transition focus:border-indigo-400 focus:outline-none">{{ old('komentar_ortu') }}</textarea>
            @error('komentar_ortu')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
        </div>

        {{-- ── Submit Button ──────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ url('/') }}"
               class="px-6 py-3 rounded-xl border border-indigo-700 text-indigo-300 text-sm font-medium hover:bg-indigo-900/40 transition text-center">
                ← Kembali ke Beranda
            </a>
            <button type="submit" id="submit-btn"
                class="px-8 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white text-sm font-semibold shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:shadow-indigo-500/50 hover:scale-105 flex items-center gap-2 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Laporan
            </button>
        </div>

    </form>
</main>

{{-- ── CKEditor Initialization ─────────────────────────────────────── --}}
<script>
    const editorIds = [
        'elemen_agama_budi_pekerti',
        'elemen_jati_diri',
        'elemen_literasi_steam',
        'projek_p5'
    ];

    const editorInstances = {};

    editorIds.forEach(id => {
        ClassicEditor
            .create(document.querySelector('#' + id), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', 'link', '|',
                        'undo', 'redo'
                    ]
                },
                placeholder: 'Tuliskan deskripsi narasi capaian pembelajaran di sini...',
            })
            .then(editor => {
                editorInstances[id] = editor;
            })
            .catch(err => console.error('CKEditor error [' + id + ']:', err));
    });

    // Sync CKEditor content ke textarea sebelum form di-submit
    document.getElementById('lpad-form').addEventListener('submit', function () {
        editorIds.forEach(id => {
            if (editorInstances[id]) {
                document.querySelector('#' + id).value = editorInstances[id].getData();
            }
        });
    });

    // Auto-hide alert sukses setelah 4 detik
    const alertEl = document.getElementById('alert-success');
    if (alertEl) setTimeout(() => alertEl.remove(), 4000);
</script>

</body>
</html>
