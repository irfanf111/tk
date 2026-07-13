<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pendaftaran – {{ $student?->nama_lengkap ?? 'N/A' }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; background: #f5f5f5; }
        .wrapper { max-width: 820px; margin: 0 auto; background: #fff; padding: 20px 30px; }

        .school-header { display: flex; align-items: center; gap: 16px; border-bottom: 3px solid #16a34a; padding-bottom: 12px; margin-bottom: 16px; }
        .logo-circle { width: 64px; height: 64px; border-radius: 50%; background: #16a34a; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px; font-weight: bold; flex-shrink: 0; }
        .school-info h1 { font-size: 17px; font-weight: bold; color: #15803d; }
        .school-info p  { font-size: 10.5px; color: #555; margin-top: 2px; }
        .doc-title    { text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .doc-subtitle { text-align: center; font-size: 10.5px; color: #666; margin-bottom: 16px; }

        .info-bar { display: flex; gap: 10px; flex-wrap: wrap; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; }
        .info-bar .item label { display: block; font-size: 9.5px; color: #6b7280; text-transform: uppercase; }
        .info-bar .item span  { font-size: 12px; font-weight: bold; color: #15803d; }

        .badge { display: inline-block; padding: 2px 10px; border-radius: 9999px; font-size: 10.5px; font-weight: bold; }
        .badge-draft        { background:#f3f4f6; color:#374151; border:1px solid #d1d5db; }
        .badge-submitted    { background:#fef9c3; color:#92400e; border:1px solid #fde047; }
        .badge-verified     { background:#dbeafe; color:#1e40af; border:1px solid #93c5fd; }
        .badge-accepted     { background:#dcfce7; color:#15803d; border:1px solid #86efac; }
        .badge-rejected, .badge-not_accepted { background:#fee2e2; color:#b91c1c; border:1px solid #fca5a5; }

        .section { margin-bottom: 14px; border: 1px solid #d1d5db; border-radius: 8px; overflow: hidden; }
        .section-header { background: #15803d; color: #fff; padding: 5px 14px; font-weight: bold; font-size: 11px; letter-spacing: 0.5px; }
        .section-body   { padding: 10px 14px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 5px 20px; }
        .field   { padding: 3px 0; border-bottom: 1px dashed #e5e7eb; }
        .field:last-child { border: none; }
        .field label { display: block; font-size: 9.5px; color: #6b7280; text-transform: uppercase; }
        .field span  { display: block; font-size: 12px; color: #111; font-weight: 500; min-height: 15px; }
        .col-full { grid-column: 1 / -1; }
        .sub-title { font-size: 11px; font-weight: bold; margin: 8px 0 4px; }
        hr.divider { border: none; border-top: 1px dashed #e5e7eb; margin: 8px 0; }

        .doc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .doc-card { border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; }
        .doc-card-head { background: #f3f4f6; padding: 5px 10px; font-size: 10px; font-weight: bold; color: #374151; }
        .doc-card-body { padding: 8px; text-align: center; min-height: 80px; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .doc-card-body img { max-width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 4px; }
        .doc-missing  { color: #9ca3af; font-style: italic; font-size: 11px; }
        .doc-pdf-link { display: inline-block; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px; padding: 5px 10px; font-size: 10.5px; color: #374151; text-decoration: none; }

        .sig-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .sig-box { border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px 14px; text-align: center; }
        .sig-box .title { font-size: 11px; font-weight: bold; margin-bottom: 50px; }
        .sig-box .name  { font-size: 11px; border-top: 1px solid #374151; padding-top: 4px; display: inline-block; min-width: 120px; }

        .no-print { text-align: center; padding: 16px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        .btn-print { background: #16a34a; color: #fff; border: none; padding: 9px 24px; font-size: 13px; border-radius: 7px; cursor: pointer; font-weight: bold; margin-right: 6px; }
        .btn-pdf   { display: inline-block; background: #1e40af; color: #fff; text-decoration: none; padding: 9px 24px; font-size: 13px; border-radius: 7px; font-weight: bold; margin-right: 6px; }
        .btn-back  { background: #e5e7eb; color: #374151; border: none; padding: 9px 18px; font-size: 13px; border-radius: 7px; cursor: pointer; }

        .page-break { display: none; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .wrapper { padding: 0; max-width: 100%; }
            .page-break { display: block; page-break-before: always; }
        }
        @page { size: A4; margin: 12mm 15mm; }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Print (Ctrl+P)</button>
    <a href="{{ route('admin.ppdb.pdf', $registration->id) }}" class="btn-pdf">📥 Unduh PDF (A4)</a>
    <button class="btn-back"  onclick="window.close()">✕ Tutup Tab</button>
</div>

<div class="wrapper">

    {{-- HEADER --}}
    <div class="school-header">
        <div class="logo-circle">TK</div>
        <div class="school-info">
            <h1>TK Puspitasari Kaliwatubumi</h1>
            <p>Penerimaan Peserta Didik Baru (PPDB) · Rekap Data Pendaftaran</p>
            <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
    </div>

    <div class="doc-title">Formulir Rekap Pendaftaran PPDB</div>
    <div class="doc-subtitle">Dokumen ini dicetak otomatis dari sistem PPDB TK Puspitasari</div>

    {{-- INFO BAR --}}
    <div class="info-bar">
        <div class="item">
            <label>ID Pendaftaran</label>
            <span>#{{ $registration->id }}</span>
        </div>
        <div class="item">
            <label>Akun Orang Tua</label>
            <span>{{ $user?->name ?? '-' }}</span>
        </div>
        <div class="item">
            <label>Email</label>
            <span>{{ $user?->email ?? '-' }}</span>
        </div>
        <div class="item">
            <label>Status</label>
            @php
                $statusLabels = \App\Models\Registration::statusLabels();
                $statusLabel  = $statusLabels[$registration->status] ?? ucfirst($registration->status);
                $badgeCls     = 'badge badge-' . $registration->status;
            @endphp
            <span class="{{ $badgeCls }}">{{ $statusLabel }}</span>
        </div>
        <div class="item">
            <label>Tanggal Daftar</label>
            <span>{{ $registration->created_at?->translatedFormat('d F Y') ?? '-' }}</span>
        </div>
        @if($registration->verifier)
        <div class="item">
            <label>Diverifikasi Oleh</label>
            <span>{{ $registration->verifier->name }}</span>
        </div>
        @endif
    </div>

    {{-- SEKSI A: DATA SISWA --}}
    <div class="section">
        <div class="section-header">A. Keterangan Siswa</div>
        <div class="section-body">
            <div class="grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <span>{{ $student?->nama_lengkap ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Nama Panggilan</label>
                    <span>{{ $student?->nama_panggilan ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Jenis Kelamin</label>
                    <span>{{ $student?->jenis_kelamin === 'L' ? 'Laki-laki' : ($student?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</span>
                </div>
                <div class="field">
                    <label>Agama</label>
                    <span>{{ $student?->agama ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Tempat Lahir</label>
                    <span>{{ $student?->tempat_lahir ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Tanggal Lahir</label>
                    <span>{{ $student?->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Kewarganegaraan</label>
                    <span>{{ $student?->kewarganegaraan ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Golongan Darah</label>
                    <span>{{ $student?->golongan_darah ?: '-' }}</span>
                </div>
                <div class="field">
                    <label>Berat / Tinggi Badan</label>
                    <span>{{ $student?->berat_badan ?? '-' }} kg / {{ $student?->tinggi_badan ?? '-' }} cm</span>
                </div>
                <div class="field">
                    <label>Anak ke- / Saudara Kandung / Tiri / Angkat</label>
                    <span>{{ $student?->anak_ke ?? '-' }} / {{ $student?->jumlah_saudara_kandung ?? 0 }} / {{ $student?->jumlah_saudara_tiri ?? 0 }} / {{ $student?->jumlah_saudara_angkat ?? 0 }}</span>
                </div>
                <div class="field">
                    <label>Bahasa Sehari-hari</label>
                    <span>{{ $student?->bahasa_sehari_hari ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Tinggal Bersama</label>
                    <span>{{ $student?->tinggal_bersama ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>No. HP / WhatsApp</label>
                    <span>{{ $student?->no_hp ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Riwayat Penyakit</label>
                    <span>{{ $student?->riwayat_penyakit ?: 'Tidak ada' }}</span>
                </div>
                <div class="field col-full">
                    <label>Alamat Lengkap</label>
                    <span>{{ $student?->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- SEKSI B: DATA ORANG TUA --}}
    <div class="section">
        <div class="section-header">B. Keterangan Orang Tua / Wali</div>
        <div class="section-body">
            <p class="sub-title" style="color:#15803d;">👨 Data Ayah</p>
            <div class="grid-2">
                <div class="field">
                    <label>Nama Ayah</label>
                    <span>{{ $parent?->nama_ayah ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Tempat, Tgl Lahir</label>
                    <span>{{ $parent?->tempat_lahir_ayah ?? '-' }}, {{ $parent?->tanggal_lahir_ayah ? \Carbon\Carbon::parse($parent->tanggal_lahir_ayah)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="field">
                    <label>Pendidikan</label>
                    <span>{{ $parent?->pendidikan_ayah ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Pekerjaan</label>
                    <span>{{ $parent?->pekerjaan_ayah ?? '-' }}</span>
                </div>
            </div>

            <hr class="divider">
            <p class="sub-title" style="color:#db2777;">👩 Data Ibu</p>
            <div class="grid-2">
                <div class="field">
                    <label>Nama Ibu</label>
                    <span>{{ $parent?->nama_ibu ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Tempat, Tgl Lahir</label>
                    <span>{{ $parent?->tempat_lahir_ibu ?? '-' }}, {{ $parent?->tanggal_lahir_ibu ? \Carbon\Carbon::parse($parent->tanggal_lahir_ibu)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="field">
                    <label>Pendidikan</label>
                    <span>{{ $parent?->pendidikan_ibu ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Pekerjaan</label>
                    <span>{{ $parent?->pekerjaan_ibu ?? '-' }}</span>
                </div>
            </div>

            @if($parent?->nama_wali)
            <hr class="divider">
            <p class="sub-title" style="color:#0891b2;">🧑‍🤝‍🧑 Data Wali</p>
            <div class="grid-2">
                <div class="field">
                    <label>Nama Wali</label>
                    <span>{{ $parent->nama_wali }}</span>
                </div>
                <div class="field">
                    <label>Hubungan</label>
                    <span>{{ $parent->hubungan_wali ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Pendidikan</label>
                    <span>{{ $parent->pendidikan_wali ?? '-' }}</span>
                </div>
                <div class="field">
                    <label>Pekerjaan</label>
                    <span>{{ $parent->pekerjaan_wali ?? '-' }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="page-break"></div>

    {{-- SEKSI C: DOKUMEN --}}
    <div class="section">
        <div class="section-header">C. Dokumen Persyaratan</div>
        <div class="section-body">
            <div class="doc-grid">

                {{-- Akta Kelahiran --}}
                <div class="doc-card">
                    <div class="doc-card-head">📄 Akta Kelahiran <span style="color:#ef4444;">*</span></div>
                    <div class="doc-card-body">
                        @if($doc?->akta_kelahiran)
                            @php $ext = strtolower(pathinfo($doc->akta_kelahiran, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img src="{{ asset('storage/' . $doc->akta_kelahiran) }}" alt="Akta Kelahiran">
                            @else
                                <a href="{{ asset('storage/' . $doc->akta_kelahiran) }}" class="doc-pdf-link" target="_blank">📂 Buka PDF</a>
                            @endif
                        @else
                            <p class="doc-missing">Belum diunggah</p>
                        @endif
                    </div>
                </div>

                {{-- Kartu Keluarga --}}
                <div class="doc-card">
                    <div class="doc-card-head">📄 Kartu Keluarga <span style="color:#ef4444;">*</span></div>
                    <div class="doc-card-body">
                        @if($doc?->kartu_keluarga)
                            @php $ext = strtolower(pathinfo($doc->kartu_keluarga, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img src="{{ asset('storage/' . $doc->kartu_keluarga) }}" alt="Kartu Keluarga">
                            @else
                                <a href="{{ asset('storage/' . $doc->kartu_keluarga) }}" class="doc-pdf-link" target="_blank">📂 Buka PDF</a>
                            @endif
                        @else
                            <p class="doc-missing">Belum diunggah</p>
                        @endif
                    </div>
                </div>

                {{-- Ijazah TK --}}
                <div class="doc-card">
                    <div class="doc-card-head">📄 Ijazah TK/PAUD <span style="color:#9ca3af;">(Opsional)</span></div>
                    <div class="doc-card-body">
                        @if($doc?->ijazah_tk)
                            @php $ext = strtolower(pathinfo($doc->ijazah_tk, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img src="{{ asset('storage/' . $doc->ijazah_tk) }}" alt="Ijazah TK">
                            @else
                                <a href="{{ asset('storage/' . $doc->ijazah_tk) }}" class="doc-pdf-link" target="_blank">📂 Buka PDF</a>
                            @endif
                        @else
                            <p class="doc-missing">Tidak diunggah</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if($registration->notes)
    <div class="section">
        <div class="section-header">Catatan Admin</div>
        <div class="section-body">
            <p style="font-size:12px; color:#374151; line-height:1.6;">{{ $registration->notes }}</p>
        </div>
    </div>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="sig-row">
        <div class="sig-box">
            <p class="title">Orang Tua / Wali,</p>
            <span class="name">{{ $parent?->nama_ayah ?? $parent?->nama_ibu ?? '( ............... )' }}</span>
        </div>
        <div class="sig-box">
            <p class="title">Mengetahui,<br><small style="font-weight:normal;">Panitia PPDB TK Puspitasari</small></p>
            <span class="name">( ............... )</span>
        </div>
    </div>

    <p style="text-align:center; font-size:10px; color:#9ca3af; margin-top:14px;">
        TK Puspitasari Kaliwatubumi · Sistem PPDB {{ now()->year }}
    </p>

</div>
</body>
</html>
