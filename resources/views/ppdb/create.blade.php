<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir PPDB – TK Puspitasari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #f4f7f6; min-height: 100vh; }
        .inp { display:block; width:100%; background:#ffffff; border:1px solid #d1d5db; border-radius:.75rem; padding:.625rem 1rem; color:#1f2937; font-size:.875rem; transition:border-color .15s,box-shadow .15s; }
        .inp:focus { outline:none; border-color:#4CAF93; box-shadow:0 0 0 3px rgba(76,175,147,.2); }
        .inp::placeholder { color:#9ca3af; }
        select.inp option { background:#ffffff; color:#1f2937; }
        .lbl { display:block; font-size:.8125rem; font-weight:500; color:#4b5563; margin-bottom:.4rem; }
        .req { color:#ef4444; }
        .card { background:#ffffff; border:1px solid #e5e7eb; border-radius:1.25rem; box-shadow:0 4px 16px rgba(0,0,0,.06); margin-bottom:1.5rem; overflow:hidden; }
        .card-header { padding:1.25rem 1.75rem; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:.875rem; background:#f9fafb; }
        .card-body { padding:1.75rem; }
        .badge { width:2rem; height:2rem; border-radius:.5rem; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.875rem; color:#fff; flex-shrink:0; }
        .sub-divider { display:flex; align-items:center; gap:.75rem; margin:1.5rem 0 1rem; }
        .sub-divider-line { flex:1; height:1px; background:#e5e7eb; }
        .sub-divider-label { font-size:.75rem; font-weight:600; letter-spacing:.05em; text-transform:uppercase; padding:.25rem .75rem; border-radius:9999px; }
        ::-webkit-scrollbar { width:6px; } ::-webkit-scrollbar-thumb { background:#4CAF93; border-radius:3px; }
        .err { color:#ef4444; font-size:.75rem; margin-top:.25rem; display:block; }
    </style>
</head>
<body class="font-['Inter'] antialiased text-gray-800">

{{-- ── NAV ──────────────────────────────────────────────── --}}
<nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-4xl mx-auto px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center shadow-md" style="background-color:#4CAF93;">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <div>
            <p class="font-bold text-gray-800 text-base leading-tight">Formulir PPDB</p>
            <p class="text-xs" style="color:#4CAF93;">Penerimaan Peserta Didik Baru · TK Puspitasari</p>
        </div>
        <a href="{{ url('/') }}" class="ml-auto text-xs text-gray-500 hover:text-gray-800 transition">← Beranda</a>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-4 py-10">

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 text-sm">
        <p class="font-semibold mb-1">⚠ Mohon periksa kembali isian berikut:</p>
        <ul class="list-disc list-inside space-y-0.5 text-red-600">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- ═══════════════════════════════════════════════════
             SECTION A — KETERANGAN SISWA
        ════════════════════════════════════════════════════════ --}}
        <div class="card">
            <div class="card-header">
                <div class="badge" style="background-color:#4CAF93;">A</div>
                <div>
                    <p class="font-semibold text-gray-800">Keterangan Siswa</p>
                    <p class="text-xs text-gray-500">Data identitas calon peserta didik</p>
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama Lengkap & NIK --}}
                    <div>
                        <label class="lbl" for="nama_siswa">Nama Lengkap <span class="req">*</span></label>
                        <input class="inp" type="text" id="nama_siswa" name="nama_siswa"
                            value="{{ old('nama_siswa') }}" placeholder="Sesuai akta kelahiran" required>
                        @error('nama_siswa')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="lbl" for="nik">NIK (16 Digit) <span class="req">*</span></label>
                        <input class="inp" type="text" id="nik" name="nik" maxlength="16"
                            value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan Anak" required>
                        @error('nik')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Nama Panggilan --}}
                    <div>
                        <label class="lbl" for="nama_panggilan">Nama Panggilan <span class="req">*</span></label>
                        <input class="inp" type="text" id="nama_panggilan" name="nama_panggilan"
                            value="{{ old('nama_panggilan', $student->nama_panggilan ?? '') }}" placeholder="cth: Budi" required>
                        @error('nama_panggilan')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="lbl" for="jenis_kelamin">Jenis Kelamin <span class="req">*</span></label>
                        <select class="inp" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">— Pilih —</option>
                            <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Tempat & Tanggal Lahir — 1 baris --}}
                    <div>
                        <label class="lbl" for="tempat_lahir">Tempat Lahir <span class="req">*</span></label>
                        <input class="inp" type="text" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}" placeholder="cth: Jakarta" required>
                        @error('tempat_lahir')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="tanggal_lahir">Tanggal Lahir <span class="req">*</span></label>
                        <input class="inp" type="date" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="lbl" for="agama">Agama <span class="req">*</span></label>
                        <input class="inp" type="text" id="agama" name="agama"
                            value="{{ old('agama') }}" placeholder="cth: Islam" required>
                        @error('agama')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Kewarganegaraan --}}
                    <div>
                        <label class="lbl" for="kewarganegaraan">Kewarganegaraan <span class="req">*</span></label>
                        <select class="inp" id="kewarganegaraan" name="kewarganegaraan" required>
                            <option value="">— Pilih —</option>
                            <option value="WNI" {{ old('kewarganegaraan', $student->kewarganegaraan ?? 'WNI')=='WNI'?'selected':'' }}>WNI (Warga Negara Indonesia)</option>
                            <option value="WNA" {{ old('kewarganegaraan', $student->kewarganegaraan ?? '')=='WNA'?'selected':'' }}>WNA (Warga Negara Asing)</option>
                        </select>
                        @error('kewarganegaraan')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Anak ke / Saudara — 4 kolom --}}
                    <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="lbl" for="anak_ke">Anak ke- <span class="req">*</span></label>
                            <input class="inp" type="number" id="anak_ke" name="anak_ke" min="1"
                                value="{{ old('anak_ke') }}" placeholder="1" required>
                            @error('anak_ke')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="lbl" for="jml_saudara_kandung">Sdr. Kandung <span class="req">*</span></label>
                            <input class="inp" type="number" id="jml_saudara_kandung" name="jml_saudara_kandung" min="0"
                                value="{{ old('jml_saudara_kandung', 0) }}" required>
                            @error('jml_saudara_kandung')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="lbl" for="jml_saudara_tiri">Sdr. Tiri</label>
                            <input class="inp" type="number" id="jml_saudara_tiri" name="jml_saudara_tiri" min="0"
                                value="{{ old('jml_saudara_tiri', 0) }}">
                            @error('jml_saudara_tiri')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="lbl" for="jml_saudara_angkat">Sdr. Angkat</label>
                            <input class="inp" type="number" id="jml_saudara_angkat" name="jml_saudara_angkat" min="0"
                                value="{{ old('jml_saudara_angkat', 0) }}">
                            @error('jml_saudara_angkat')<span class="err">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- BB / TB / Gol Darah — 3 kolom --}}
                    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="lbl" for="berat_badan">Berat Badan (kg) <span class="req">*</span></label>
                            <input class="inp" type="number" step="0.1" min="1" id="berat_badan" name="berat_badan"
                                value="{{ old('berat_badan') }}" placeholder="cth: 18.5" required>
                            @error('berat_badan')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="lbl" for="tinggi_badan">Tinggi Badan (cm) <span class="req">*</span></label>
                            <input class="inp" type="number" step="0.1" min="30" id="tinggi_badan" name="tinggi_badan"
                                value="{{ old('tinggi_badan') }}" placeholder="cth: 110.0" required>
                            @error('tinggi_badan')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="lbl" for="golongan_darah">Golongan Darah</label>
                            <select class="inp" id="golongan_darah" name="golongan_darah">
                                <option value="">- (Belum diketahui)</option>
                                @foreach(['A','B','AB','O'] as $g)
                                <option value="{{ $g }}" {{ old('golongan_darah')==$g?'selected':'' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div class="md:col-span-2">
                        <label class="lbl" for="riwayat_penyakit">Riwayat Penyakit</label>
                        <input class="inp" type="text" id="riwayat_penyakit" name="riwayat_penyakit"
                            value="{{ old('riwayat_penyakit') }}" placeholder="Kosongkan jika tidak ada. cth: Asma, Alergi debu">
                    </div>

                    {{-- Bahasa Sehari-hari --}}
                    <div>
                        <label class="lbl" for="bahasa_sehari_hari">Bahasa Sehari-hari <span class="req">*</span></label>
                        <input class="inp" type="text" id="bahasa_sehari_hari" name="bahasa_sehari_hari"
                            value="{{ old('bahasa_sehari_hari','Indonesia') }}" required>
                        @error('bahasa_sehari_hari')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="lbl" for="no_hp">Nomor HP / WhatsApp <span class="req">*</span></label>
                        <input class="inp" type="tel" id="no_hp" name="no_hp"
                            value="{{ old('no_hp') }}" placeholder="cth: 08123456789" required>
                        @error('no_hp')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Tinggal Bersama --}}
                    <div>
                        <label class="lbl" for="tinggal_bersama">Tinggal Bersama <span class="req">*</span></label>
                        <select class="inp" id="tinggal_bersama" name="tinggal_bersama" required>
                            <option value="">— Pilih —</option>
                            <option value="orang_tua" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '')=='orang_tua'?'selected':'' }}>Orang Tua</option>
                            <option value="menumpang" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '')=='menumpang'?'selected':'' }}>Menumpang</option>
                            <option value="asrama" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '')=='asrama'?'selected':'' }}>Asrama</option>
                            <option value="kontrak" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '')=='kontrak'?'selected':'' }}>Kontrak / Kost</option>
                        </select>
                        @error('tinggal_bersama')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="lbl" for="alamat">Alamat Lengkap <span class="req">*</span></label>
                        <textarea class="inp resize-y" id="alamat" name="alamat" rows="3"
                            placeholder="Jl. Contoh No. 1, RT 01/RW 02, Kelurahan, Kecamatan, Kota" required>{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="err">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════
             SECTION B — KETERANGAN ORANG TUA / WALI
        ════════════════════════════════════════════════════════ --}}
        <div class="card">
            <div class="card-header">
                <div class="badge" style="background-color:#3b9a7a;">B</div>
                <div>
                    <p class="font-semibold text-gray-800">Keterangan Orang Tua / Wali</p>
                    <p class="text-xs text-gray-500">Data penanggung jawab peserta didik</p>
                </div>
            </div>
            <div class="card-body space-y-2">

                {{-- ── AYAH ────────────────────────────────── --}}
                <div class="sub-divider">
                    <span class="sub-divider-label bg-blue-50 text-blue-700 border border-blue-200">👨 Data Ayah</span>
                    <div class="sub-divider-line"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="lbl" for="nama_ayah">Nama Lengkap Ayah <span class="req">*</span></label>
                        <input class="inp" type="text" id="nama_ayah" name="nama_ayah"
                            value="{{ old('nama_ayah') }}" placeholder="Nama sesuai KTP" required>
                        @error('nama_ayah')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="tempat_lahir_ayah">Tempat Lahir <span class="req">*</span></label>
                        <input class="inp" type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah"
                            value="{{ old('tempat_lahir_ayah', $studentParent->tempat_lahir_ayah ?? '') }}" placeholder="cth: Bandung" required>
                        @error('tempat_lahir_ayah')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="tanggal_lahir_ayah">Tanggal Lahir <span class="req">*</span></label>
                        <input class="inp" type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah"
                            value="{{ old('tanggal_lahir_ayah', isset($studentParent->tanggal_lahir_ayah) ? \Carbon\Carbon::parse($studentParent->tanggal_lahir_ayah)->format('Y-m-d') : '') }}" required>
                        @error('tanggal_lahir_ayah')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="pendidikan_ayah">Pendidikan Terakhir <span class="req">*</span></label>
                        <select class="inp" id="pendidikan_ayah" name="pendidikan_ayah" required>
                            <option value="">— Pilih —</option>
                            @foreach(['SD','SMP','SMA/SMK','D1','D2','D3','S1','S2','S3','Lainnya'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan_ayah', $studentParent->pendidikan_ayah ?? '')==$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan_ayah')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="pekerjaan_ayah">Pekerjaan <span class="req">*</span></label>
                        <input class="inp" type="text" id="pekerjaan_ayah" name="pekerjaan_ayah"
                            value="{{ old('pekerjaan_ayah', $studentParent->pekerjaan_ayah ?? '') }}" placeholder="cth: Wiraswasta" required>
                        @error('pekerjaan_ayah')<span class="err">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- ── IBU ─────────────────────────────────── --}}
                <div class="sub-divider">
                    <span class="sub-divider-label bg-pink-50 text-pink-700 border border-pink-200">👩 Data Ibu</span>
                    <div class="sub-divider-line"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="lbl" for="nama_ibu">Nama Lengkap Ibu <span class="req">*</span></label>
                        <input class="inp" type="text" id="nama_ibu" name="nama_ibu"
                            value="{{ old('nama_ibu') }}" placeholder="Nama sesuai KTP" required>
                        @error('nama_ibu')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="tempat_lahir_ibu">Tempat Lahir <span class="req">*</span></label>
                        <input class="inp" type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu"
                            value="{{ old('tempat_lahir_ibu', $studentParent->tempat_lahir_ibu ?? '') }}" placeholder="cth: Surabaya" required>
                        @error('tempat_lahir_ibu')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="tanggal_lahir_ibu">Tanggal Lahir <span class="req">*</span></label>
                        <input class="inp" type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu"
                            value="{{ old('tanggal_lahir_ibu', isset($studentParent->tanggal_lahir_ibu) ? \Carbon\Carbon::parse($studentParent->tanggal_lahir_ibu)->format('Y-m-d') : '') }}" required>
                        @error('tanggal_lahir_ibu')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="pendidikan_ibu">Pendidikan Terakhir <span class="req">*</span></label>
                        <select class="inp" id="pendidikan_ibu" name="pendidikan_ibu" required>
                            <option value="">— Pilih —</option>
                            @foreach(['SD','SMP','SMA/SMK','D1','D2','D3','S1','S2','S3','Lainnya'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan_ibu', $studentParent->pendidikan_ibu ?? '')==$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan_ibu')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="pekerjaan_ibu">Pekerjaan <span class="req">*</span></label>
                        <input class="inp" type="text" id="pekerjaan_ibu" name="pekerjaan_ibu"
                            value="{{ old('pekerjaan_ibu', $studentParent->pekerjaan_ibu ?? '') }}" placeholder="cth: Ibu Rumah Tangga" required>
                        @error('pekerjaan_ibu')<span class="err">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- ── WALI ────────────────────────────────── --}}
                <div class="sub-divider">
                    <span class="sub-divider-label bg-teal-50 text-teal-700 border border-teal-200">🧑‍🤝‍🧑 Data Wali <span class="normal-case font-normal opacity-70">(Opsional)</span></span>
                    <div class="sub-divider-line"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="lbl" for="nama_wali">Nama Lengkap Wali</label>
                        <input class="inp" type="text" id="nama_wali" name="nama_wali"
                            value="{{ old('nama_wali') }}" placeholder="Kosongkan jika tidak ada wali selain orang tua">
                    </div>
                    <div>
                        <label class="lbl" for="hubungan_anak_wali">Hubungan dengan Anak</label>
                        <input class="inp" type="text" id="hubungan_anak_wali" name="hubungan_anak_wali"
                            value="{{ old('hubungan_anak_wali') }}" placeholder="cth: Kakek, Bibi, Paman">
                        @error('hubungan_anak_wali')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="lbl" for="pendidikan_wali">Pendidikan Terakhir</label>
                        <select class="inp" id="pendidikan_wali" name="pendidikan_wali">
                            <option value="">— Pilih —</option>
                            @foreach(['SD','SMP','SMA/SMK','D1','D2','D3','S1','S2','S3','Lainnya'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan_wali')==$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="lbl" for="pekerjaan_wali">Pekerjaan</label>
                        <input class="inp" type="text" id="pekerjaan_wali" name="pekerjaan_wali"
                            value="{{ old('pekerjaan_wali') }}" placeholder="cth: Pedagang">
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════
             SECTION C — UPLOAD DOKUMEN
        ════════════════════════════════════════════════════════ --}}
        <div class="card">
            <div class="card-header">
                <div class="badge" style="background-color:#7c6ab5;">C</div>
                <div>
                    <p class="font-semibold text-gray-800">Upload Dokumen</p>
                    <p class="text-xs text-gray-500">Akta & KK wajib sebelum submit. Maks. 2 MB per file (PDF/JPG/PNG).</p>
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    {{-- Akta Kelahiran --}}
                    <div>
                        <label class="lbl" for="akta_kelahiran">Akta Kelahiran <span class="req">*</span></label>
                        @if(!empty($document->akta_kelahiran))
                            <p class="text-xs text-green-600 mb-1">✓ Sudah diupload. Upload baru untuk mengganti.</p>
                        @endif
                        <input class="inp py-2" type="file" id="akta_kelahiran" name="akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png">
                        @error('akta_kelahiran')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Kartu Keluarga --}}
                    <div>
                        <label class="lbl" for="kartu_keluarga">Kartu Keluarga (KK) <span class="req">*</span></label>
                        @if(!empty($document->kartu_keluarga))
                            <p class="text-xs text-green-600 mb-1">✓ Sudah diupload. Upload baru untuk mengganti.</p>
                        @endif
                        <input class="inp py-2" type="file" id="kartu_keluarga" name="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png">
                        @error('kartu_keluarga')<span class="err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Ijazah TK --}}
                    <div>
                        <label class="lbl" for="ijazah_tk">Ijazah TK <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        @if(!empty($document->ijazah_tk))
                            <p class="text-xs text-green-600 mb-1">✓ Sudah diupload. Upload baru untuk mengganti.</p>
                        @endif
                        <input class="inp py-2" type="file" id="ijazah_tk" name="ijazah_tk" accept=".pdf,.jpg,.jpeg,.png">
                        @error('ijazah_tk')<span class="err">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── ALERT PERSETUJUAN ──────────────────────────────── --}}
        <div class="flex gap-4 items-start bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 mb-6">
            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-amber-700 text-sm leading-relaxed">
                <span class="font-semibold text-amber-800">Pernyataan Orang Tua / Wali:</span>
                Dengan menekan tombol <em>Kirim Pendaftaran</em>, saya menyatakan bahwa data yang diisikan di atas adalah
                <strong class="text-amber-800">benar adanya</strong> dan dapat dipertanggungjawabkan. Apabila terdapat
                ketidaksesuaian data, pihak sekolah berhak membatalkan pendaftaran.
            </p>
        </div>

        {{-- ── TOMBOL SUBMIT ──────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-end">
            <a href="{{ url('/') }}"
               class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 text-sm font-medium hover:bg-gray-100 hover:text-gray-800 transition-all text-center">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-3 rounded-xl text-white text-sm font-semibold shadow-md active:scale-95 transition-all duration-200 flex items-center justify-center gap-2"
                style="background: linear-gradient(135deg, #4CAF93 0%, #3b9a7a 100%); box-shadow: 0 4px 14px rgba(76,175,147,.35);"
                onmouseover="this.style.filter='brightness(1.07)'" onmouseout="this.style.filter='brightness(1)'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Kirim Pendaftaran
            </button>
        </div>

    </form>
</main>

</body>
</html>
