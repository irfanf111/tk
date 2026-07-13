<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir PPDB – {{ $student?->nama_lengkap ?? 'N/A' }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 12mm 15mm 12mm 15mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.35;
            color: #222;
            margin: 0;
            padding: 0;
        }

        /* ─── KOP SURAT ────────────────────────────────────────── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #15803d;
            padding-bottom: 8pt;
            margin-bottom: 12pt;
        }
        .kop-logo {
            width: 50pt;
            text-align: left;
            vertical-align: middle;
        }
        .kop-logo-circle {
            width: 42pt;
            height: 42pt;
            line-height: 42pt;
            border-radius: 50%;
            background-color: #15803d;
            color: #ffffff;
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
        }
        .kop-text {
            text-align: left;
            vertical-align: middle;
            padding-left: 10pt;
        }
        .kop-text h2 {
            font-size: 14pt;
            font-weight: bold;
            color: #15803d;
            margin: 0 0 2pt 0;
            text-transform: uppercase;
        }
        .kop-text p {
            font-size: 8.5pt;
            color: #555;
            margin: 0;
        }

        /* ─── TITLE & INFO BAR ─────────────────────────────────── */
        .doc-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #111;
            margin-bottom: 10pt;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            margin-bottom: 12pt;
        }
        .info-table td {
            padding: 5pt 8pt;
            vertical-align: top;
        }
        .info-label {
            font-size: 7.5pt;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 2pt;
        }
        .info-value {
            font-size: 9pt;
            font-weight: bold;
            color: #15803d;
        }

        /* ─── SECTION STYLING ─────────────────────────────────── */
        .section-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #ffffff;
            background-color: #15803d;
            padding: 4pt 8pt;
            margin-top: 10pt;
            margin-bottom: 6pt;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
        }
        .grid-table td {
            padding: 3.5pt 4pt;
            vertical-align: middle;
            border-bottom: 1px dashed #e5e7eb;
        }
        .grid-table tr:last-child td {
            border-bottom: none;
        }
        .field-label {
            font-weight: bold;
            color: #555;
        }
        .field-value {
            color: #111;
        }

        /* ─── DOKUMEN ────────────────────────────────────────── */
        .doc-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5pt;
        }
        .doc-table td {
            width: 33.33%;
            padding: 6pt;
            vertical-align: top;
        }
        .doc-card {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #ffffff;
            overflow: hidden;
            text-align: center;
        }
        .doc-card-header {
            background-color: #f3f4f6;
            font-weight: bold;
            font-size: 8pt;
            color: #374151;
            padding: 4pt;
            border-bottom: 1px solid #d1d5db;
        }
        .doc-card-body {
            padding: 6pt;
            height: 120pt;
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            width: 100%;
        }
        .doc-img {
            max-width: 100%;
            max-height: 100pt;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }
        .doc-missing {
            font-size: 8pt;
            color: #9ca3af;
            font-style: italic;
        }

        /* ─── TANDA TANGAN ────────────────────────────────────── */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25pt;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-title {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 45pt;
        }
        .ttd-name {
            font-size: 9pt;
            font-weight: bold;
            border-top: 1px solid #333;
            display: inline-block;
            min-width: 130pt;
            padding-top: 3pt;
        }

        /* ─── PAGE SYSTEM ─────────────────────────────────────── */
        .page-break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7.5pt;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- PAGE 1 --}}
    <div class="page">
        {{-- KOP SURAT --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <div class="kop-logo-circle">TK</div>
                </td>
                <td class="kop-text">
                    <h2>TK Puspitasari Kaliwatubumi</h2>
                    <p>Penerimaan Peserta Didik Baru (PPDB) · Rekap Pendaftaran</p>
                    <p>Alamat Sekolah: Kaliwatubumi, Kec. Butuh, Kabupaten Purworejo, Jawa Tengah</p>
                </td>
            </tr>
        </table>

        <div class="doc-title">Formulir Rekap Pendaftaran PPDB</div>

        {{-- INFO BAR --}}
        <table class="info-table">
            <tr>
                <td style="width: 20%;">
                    <div class="info-label">ID Daftar</div>
                    <div class="info-value">#{{ $registration->id }}</div>
                </td>
                <td style="width: 30%;">
                    <div class="info-label">Akun Orang Tua</div>
                    <div class="info-value">{{ $user?->name ?? '-' }}</div>
                </td>
                <td style="width: 30%;">
                    <div class="info-label">Status Verifikasi</div>
                    <div class="info-value">
                        @php
                            $statusLabels = \App\Models\Registration::statusLabels();
                            echo $statusLabels[$registration->status] ?? ucfirst($registration->status);
                        @endphp
                    </div>
                </td>
                <td style="width: 20%;">
                    <div class="info-label">Tgl Daftar</div>
                    <div class="info-value">{{ $registration->created_at?->translatedFormat('d F Y') ?? '-' }}</div>
                </td>
            </tr>
        </table>

        {{-- A. KETERANGAN SISWA --}}
        <div class="section-title">A. Keterangan Siswa</div>
        <table class="grid-table">
            <tr>
                <td class="field-label" style="width: 20%;">Nama Lengkap</td>
                <td style="width: 2%;">:</td>
                <td class="field-value" style="width: 28%;">{{ $student?->nama_lengkap ?? '-' }}</td>
                <td class="field-label" style="width: 20%;">Nama Panggilan</td>
                <td style="width: 2%;">:</td>
                <td class="field-value" style="width: 28%;">{{ $student?->nama_panggilan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Jenis Kelamin</td>
                <td>:</td>
                <td class="field-value">{{ $student?->jenis_kelamin === 'L' ? 'Laki-laki' : ($student?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
                <td class="field-label">Agama</td>
                <td>:</td>
                <td class="field-value">{{ $student?->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Tempat Lahir</td>
                <td>:</td>
                <td class="field-value">{{ $student?->tempat_lahir ?? '-' }}</td>
                <td class="field-label">Tanggal Lahir</td>
                <td>:</td>
                <td class="field-value">{{ $student?->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Kewarganegaraan</td>
                <td>:</td>
                <td class="field-value">{{ $student?->kewarganegaraan ?? '-' }}</td>
                <td class="field-label">Golongan Darah</td>
                <td>:</td>
                <td class="field-value">{{ $student?->golongan_darah ?: '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Berat / Tinggi</td>
                <td>:</td>
                <td class="field-value">{{ $student?->berat_badan ?? '-' }} kg / {{ $student?->tinggi_badan ?? '-' }} cm</td>
                <td class="field-label">Anak Ke / Saudara</td>
                <td>:</td>
                <td class="field-value">{{ $student?->anak_ke ?? '-' }} / {{ $student?->jumlah_saudara_kandung ?? 0 }} Kandung</td>
            </tr>
            <tr>
                <td class="field-label">Bahasa</td>
                <td>:</td>
                <td class="field-value">{{ $student?->bahasa_sehari_hari ?? '-' }}</td>
                <td class="field-label">Tinggal Bersama</td>
                <td>:</td>
                <td class="field-value">{{ $student?->tinggal_bersama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">No. HP / WA</td>
                <td>:</td>
                <td class="field-value">{{ $student?->no_hp ?? '-' }}</td>
                <td class="field-label">Riwayat Sakit</td>
                <td>:</td>
                <td class="field-value">{{ $student?->riwayat_penyakit ?: 'Tidak ada' }}</td>
            </tr>
            <tr>
                <td class="field-label">Alamat Lengkap</td>
                <td>:</td>
                <td class="field-value" colspan="4">{{ $student?->alamat ?? '-' }}</td>
            </tr>
        </table>

        {{-- B. KETERANGAN ORANG TUA / WALI --}}
        <div class="section-title">B. Keterangan Orang Tua / Wali</div>
        
        <table class="grid-table">
            <tr>
                <td colspan="6" style="font-weight: bold; color: #15803d; border: none; padding-top: 2pt; padding-bottom: 2pt;">👨 Data Ayah</td>
            </tr>
            <tr>
                <td class="field-label" style="width: 20%;">Nama Ayah</td>
                <td style="width: 2%;">:</td>
                <td class="field-value" style="width: 28%;">{{ $parent?->nama_ayah ?? '-' }}</td>
                <td class="field-label" style="width: 20%;">Tempat, Tgl Lahir</td>
                <td style="width: 2%;">:</td>
                <td class="field-value" style="width: 28%;">{{ $parent?->tempat_lahir_ayah ?? '-' }}, {{ $parent?->tanggal_lahir_ayah ? \Carbon\Carbon::parse($parent->tanggal_lahir_ayah)->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Pendidikan</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->pendidikan_ayah ?? '-' }}</td>
                <td class="field-label">Pekerjaan</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->pekerjaan_ayah ?? '-' }}</td>
            </tr>

            <tr>
                <td colspan="6" style="font-weight: bold; color: #db2777; border: none; padding-top: 6pt; padding-bottom: 2pt;">👩 Data Ibu</td>
            </tr>
            <tr>
                <td class="field-label">Nama Ibu</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->nama_ibu ?? '-' }}</td>
                <td class="field-label">Tempat, Tgl Lahir</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->tempat_lahir_ibu ?? '-' }}, {{ $parent?->tanggal_lahir_ibu ? \Carbon\Carbon::parse($parent->tanggal_lahir_ibu)->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Pendidikan</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->pendidikan_ibu ?? '-' }}</td>
                <td class="field-label">Pekerjaan</td>
                <td>:</td>
                <td class="field-value">{{ $parent?->pekerjaan_ibu ?? '-' }}</td>
            </tr>

            @if($parent?->nama_wali)
            <tr>
                <td colspan="6" style="font-weight: bold; color: #0891b2; border: none; padding-top: 6pt; padding-bottom: 2pt;">🧑‍🤝‍🧑 Data Wali</td>
            </tr>
            <tr>
                <td class="field-label">Nama Wali</td>
                <td>:</td>
                <td class="field-value">{{ $parent->nama_wali }}</td>
                <td class="field-label">Hubungan</td>
                <td>:</td>
                <td class="field-value">{{ $parent->hubungan_wali ?? '-' }}</td>
            </tr>
            <tr>
                <td class="field-label">Pendidikan</td>
                <td>:</td>
                <td class="field-value">{{ $parent->pendidikan_wali ?? '-' }}</td>
                <td class="field-label">Pekerjaan</td>
                <td>:</td>
                <td class="field-value">{{ $parent->pekerjaan_wali ?? '-' }}</td>
            </tr>
            @endif
        </table>

        <div class="footer">
            Halaman 1 dari 2 &nbsp;|&nbsp; PPDB TK Puspitasari Kaliwatubumi
        </div>
    </div>

    <div class="page-break"></div>

    {{-- PAGE 2 --}}
    <div class="page">
        {{-- C. DOKUMEN PERSYARATAN --}}
        <div class="section-title">C. Dokumen Persyaratan</div>
        
        <table class="doc-table">
            <tr>
                <td>
                    <div class="doc-card">
                        <div class="doc-card-header">Akta Kelahiran *</div>
                        <div class="doc-card-body">
                            @if($doc?->akta_kelahiran && file_exists(public_path('storage/' . $doc->akta_kelahiran)))
                                @php $ext = strtolower(pathinfo($doc->akta_kelahiran, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                    <img class="doc-img" src="{{ public_path('storage/' . $doc->akta_kelahiran) }}" alt="Akta Kelahiran">
                                @else
                                    <span class="doc-missing">Berkas PDF (Tersedia)</span>
                                @endif
                            @else
                                <span class="doc-missing">Belum diunggah</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="doc-card">
                        <div class="doc-card-header">Kartu Keluarga *</div>
                        <div class="doc-card-body">
                            @if($doc?->kartu_keluarga && file_exists(public_path('storage/' . $doc->kartu_keluarga)))
                                @php $ext = strtolower(pathinfo($doc->kartu_keluarga, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                    <img class="doc-img" src="{{ public_path('storage/' . $doc->kartu_keluarga) }}" alt="Kartu Keluarga">
                                @else
                                    <span class="doc-missing">Berkas PDF (Tersedia)</span>
                                @endif
                            @else
                                <span class="doc-missing">Belum diunggah</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="doc-card">
                        <div class="doc-card-header">Ijazah TK/PAUD</div>
                        <div class="doc-card-body">
                            @if($doc?->ijazah_tk && file_exists(public_path('storage/' . $doc->ijazah_tk)))
                                @php $ext = strtolower(pathinfo($doc->ijazah_tk, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                    <img class="doc-img" src="{{ public_path('storage/' . $doc->ijazah_tk) }}" alt="Ijazah TK">
                                @else
                                    <span class="doc-missing">Berkas PDF (Tersedia)</span>
                                @endif
                            @else
                                <span class="doc-missing">Tidak diunggah</span>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        @if($registration->notes)
        <div class="section-title">Catatan Verifikasi Admin</div>
        <div style="padding: 6pt 10pt; background-color: #fafafa; border: 1px solid #e5e7eb; border-radius: 4px; font-size: 8.5pt; color: #444; margin-top: 5pt; line-height: 1.5;">
            {{ $registration->notes }}
        </div>
        @endif

        {{-- TANDA TANGAN --}}
        <table class="ttd-table">
            <tr>
                <td>
                    <div class="ttd-title">Orang Tua / Wali,</div>
                    <div class="ttd-name">{{ $parent?->nama_ayah ?? $parent?->nama_ibu ?? '( ............................. )' }}</div>
                </td>
                <td>
                    <div class="ttd-title">
                        Kaliwatubumi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        <span style="font-weight: normal; font-size: 8pt; color: #555;">Panitia PPDB TK Puspitasari</span>
                    </div>
                    <div class="ttd-name">( ............................. )</div>
                </td>
            </tr>
        </table>

        <div class="footer" style="margin-top: 40pt;">
            Halaman 2 dari 2 &nbsp;|&nbsp; PPDB TK Puspitasari Kaliwatubumi
        </div>
    </div>

</body>
</html>
