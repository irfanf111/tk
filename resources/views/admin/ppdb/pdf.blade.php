<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir PPDB – {{ $student?->nama_lengkap ?? 'N/A' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 10mm 15mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #222;
            margin: 0;
            padding: 0;
        }

        /* ─── KOP SURAT ─────────────────────────────── */
        .kop { width: 100%; border-collapse: collapse; margin-bottom: 6pt; }
        .kop td { vertical-align: middle; padding: 0; }
        .kop-logo {
            width: 44pt;
            height: 44pt;
            background-color: #15803d;
            color: #fff;
            font-size: 15pt;
            font-weight: bold;
            text-align: center;
            line-height: 44pt;
            border-radius: 50%;
        }
        .kop-info { padding-left: 10pt; }
        .kop-info .sekolah {
            font-size: 13pt;
            font-weight: bold;
            color: #15803d;
            margin: 0 0 1pt 0;
            text-transform: uppercase;
        }
        .kop-info .alamat { font-size: 7.5pt; color: #666; margin: 0; }
        .kop-border { border-bottom: 2.5pt solid #15803d; margin-bottom: 8pt; }

        /* ─── JUDUL ─────────────────────────────────── */
        .judul {
            text-align: center;
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            margin-bottom: 8pt;
            color: #111;
        }

        /* ─── INFO BAR ──────────────────────────────── */
        .infobar {
            width: 100%;
            border-collapse: collapse;
            background: #f0fdf4;
            border: 1pt solid #86efac;
            margin-bottom: 10pt;
        }
        .infobar td { padding: 5pt 8pt; vertical-align: top; }
        .infobar .lbl { font-size: 7pt; color: #777; text-transform: uppercase; }
        .infobar .val { font-size: 9pt; font-weight: bold; color: #15803d; }

        /* ─── SECTION HEADING ───────────────────────── */
        .sec {
            background: #15803d;
            color: #fff;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 3.5pt 7pt;
            margin: 8pt 0 4pt 0;
            border-radius: 3pt;
        }

        /* ─── DATA TABLE ────────────────────────────── */
        .dt {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4pt;
        }
        .dt td {
            padding: 2.5pt 3pt;
            vertical-align: top;
            border-bottom: 0.5pt dashed #ddd;
        }
        .dt tr:last-child td { border-bottom: none; }
        .dt .lbl { font-weight: bold; color: #555; width: 22%; }
        .dt .sep { width: 2%; }
        .dt .val { color: #111; }
        .dt .sub {
            font-size: 8pt;
            font-weight: bold;
            color: #15803d;
            padding: 4pt 3pt 1pt;
            border-bottom: none;
        }
        .dt .sub-pink { color: #db2777; }
        .dt .sub-blue { color: #0891b2; }

        /* ─── DOKUMEN CARDS ─────────────────────────── */
        .doc-outer { width: 100%; border-collapse: collapse; margin-top: 4pt; }
        .doc-outer td { width: 33.33%; padding: 4pt; vertical-align: top; }
        .doc-card { border: 0.75pt solid #d1d5db; border-radius: 4pt; }
        .doc-card-h {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 7.5pt;
            color: #374151;
            padding: 3.5pt 5pt;
            border-bottom: 0.75pt solid #d1d5db;
            text-align: center;
        }
        .doc-card-b {
            padding: 5pt;
            text-align: center;
            height: 110pt;
        }
        .doc-img {
            max-width: 100%;
            max-height: 100pt;
        }
        .doc-miss { font-size: 7.5pt; color: #aaa; font-style: italic; }

        /* ─── TANDA TANGAN ──────────────────────────── */
        .ttd { width: 100%; border-collapse: collapse; margin-top: 20pt; }
        .ttd td { width: 50%; text-align: center; padding: 0 10pt; }
        .ttd .role { font-size: 8.5pt; font-weight: bold; margin-bottom: 40pt; }
        .ttd .nama-line {
            border-top: 0.75pt solid #333;
            font-size: 8.5pt;
            font-weight: bold;
            padding-top: 3pt;
            min-width: 120pt;
            display: inline-block;
        }

        /* ─── CATATAN ───────────────────────────────── */
        .catatan {
            border: 0.75pt solid #e5e7eb;
            border-radius: 3pt;
            background: #fafafa;
            padding: 5pt 8pt;
            font-size: 8pt;
            color: #555;
            margin-bottom: 6pt;
        }

        /* ─── PAGE BREAK ────────────────────────────── */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

{{-- ━━━━━━━━━━━━━━━━━ HALAMAN 1 ━━━━━━━━━━━━━━━━━ --}}

{{-- KOP --}}
<table class="kop">
    <tr>
        <td style="width:50pt;">
            <div class="kop-logo">TK</div>
        </td>
        <td class="kop-info">
            <p class="sekolah">TK Puspitasari Kaliwatubumi</p>
            <p class="alamat">Penerimaan Peserta Didik Baru (PPDB)</p>
            <p class="alamat">Kaliwatubumi, Kec. Butuh, Kabupaten Purworejo, Jawa Tengah</p>
        </td>
    </tr>
</table>
<div class="kop-border"></div>

<div class="judul">Formulir Rekap Pendaftaran PPDB</div>

{{-- INFO BAR --}}
<table class="infobar">
    <tr>
        <td style="width:18%;">
            <div class="lbl">ID Daftar</div>
            <div class="val">#{{ $registration->id }}</div>
        </td>
        <td style="width:30%;">
            <div class="lbl">Akun Orang Tua</div>
            <div class="val">{{ $user?->name ?? '-' }}</div>
        </td>
        <td style="width:30%;">
            <div class="lbl">Status Verifikasi</div>
            <div class="val">
                @php
                    $statusLabels = \App\Models\Registration::statusLabels();
                    echo $statusLabels[$registration->status] ?? ucfirst($registration->status);
                @endphp
            </div>
        </td>
        <td style="width:22%;">
            <div class="lbl">Tgl Daftar</div>
            <div class="val">{{ $registration->created_at?->translatedFormat('d F Y') ?? '-' }}</div>
        </td>
    </tr>
</table>

{{-- A. KETERANGAN SISWA --}}
<div class="sec">A. Keterangan Siswa</div>
<table class="dt">
    <tr>
        <td class="lbl">Nama Lengkap</td><td class="sep">:</td>
        <td class="val" style="width:28%;">{{ $student?->nama_lengkap ?? '-' }}</td>
        <td class="lbl">Nama Panggilan</td><td class="sep">:</td>
        <td class="val" style="width:28%;">{{ $student?->nama_panggilan ?? '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Jenis Kelamin</td><td class="sep">:</td>
        <td class="val">{{ $student?->jenis_kelamin === 'L' ? 'Laki-laki' : ($student?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
        <td class="lbl">Agama</td><td class="sep">:</td>
        <td class="val">{{ $student?->agama ?? '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Tempat Lahir</td><td class="sep">:</td>
        <td class="val">{{ $student?->tempat_lahir ?? '-' }}</td>
        <td class="lbl">Tanggal Lahir</td><td class="sep">:</td>
        <td class="val">{{ $student?->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Kewarganegaraan</td><td class="sep">:</td>
        <td class="val">{{ $student?->kewarganegaraan ?? '-' }}</td>
        <td class="lbl">Golongan Darah</td><td class="sep">:</td>
        <td class="val">{{ $student?->golongan_darah ?: '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Berat / Tinggi</td><td class="sep">:</td>
        <td class="val">{{ $student?->berat_badan ?? '-' }} kg / {{ $student?->tinggi_badan ?? '-' }} cm</td>
        <td class="lbl">Anak Ke / Saudara</td><td class="sep">:</td>
        <td class="val">{{ $student?->anak_ke ?? '-' }} / {{ $student?->jumlah_saudara_kandung ?? 0 }} Kandung</td>
    </tr>
    <tr>
        <td class="lbl">Bahasa Sehari-hari</td><td class="sep">:</td>
        <td class="val">{{ $student?->bahasa_sehari_hari ?? '-' }}</td>
        <td class="lbl">Tinggal Bersama</td><td class="sep">:</td>
        <td class="val">{{ $student?->tinggal_bersama ?? '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">No. HP / WA</td><td class="sep">:</td>
        <td class="val">{{ $student?->no_hp ?? '-' }}</td>
        <td class="lbl">Riwayat Sakit</td><td class="sep">:</td>
        <td class="val">{{ $student?->riwayat_penyakit ?: 'Tidak ada' }}</td>
    </tr>
    <tr>
        <td class="lbl">Alamat Lengkap</td><td class="sep">:</td>
        <td class="val" colspan="4">{{ $student?->alamat ?? '-' }}</td>
    </tr>
</table>

{{-- B. KETERANGAN ORANG TUA / WALI --}}
<div class="sec">B. Keterangan Orang Tua / Wali</div>
<table class="dt">
    {{-- Ayah --}}
    <tr><td colspan="6" class="sub">Data Ayah</td></tr>
    <tr>
        <td class="lbl">Nama Ayah</td><td class="sep">:</td>
        <td class="val" style="width:28%;">{{ $parent?->nama_ayah ?? '-' }}</td>
        <td class="lbl">Tempat, Tgl Lahir</td><td class="sep">:</td>
        <td class="val" style="width:28%;">{{ $parent?->tempat_lahir_ayah ?? '-' }}, {{ $parent?->tanggal_lahir_ayah ? \Carbon\Carbon::parse($parent->tanggal_lahir_ayah)->translatedFormat('d F Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Pendidikan</td><td class="sep">:</td>
        <td class="val">{{ $parent?->pendidikan_ayah ?? '-' }}</td>
        <td class="lbl">Pekerjaan</td><td class="sep">:</td>
        <td class="val">{{ $parent?->pekerjaan_ayah ?? '-' }}</td>
    </tr>
    {{-- Ibu --}}
    <tr><td colspan="6" class="sub sub-pink">Data Ibu</td></tr>
    <tr>
        <td class="lbl">Nama Ibu</td><td class="sep">:</td>
        <td class="val">{{ $parent?->nama_ibu ?? '-' }}</td>
        <td class="lbl">Tempat, Tgl Lahir</td><td class="sep">:</td>
        <td class="val">{{ $parent?->tempat_lahir_ibu ?? '-' }}, {{ $parent?->tanggal_lahir_ibu ? \Carbon\Carbon::parse($parent->tanggal_lahir_ibu)->translatedFormat('d F Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Pendidikan</td><td class="sep">:</td>
        <td class="val">{{ $parent?->pendidikan_ibu ?? '-' }}</td>
        <td class="lbl">Pekerjaan</td><td class="sep">:</td>
        <td class="val">{{ $parent?->pekerjaan_ibu ?? '-' }}</td>
    </tr>
    {{-- Wali --}}
    @if($parent?->nama_wali)
    <tr><td colspan="6" class="sub sub-blue">Data Wali</td></tr>
    <tr>
        <td class="lbl">Nama Wali</td><td class="sep">:</td>
        <td class="val">{{ $parent->nama_wali }}</td>
        <td class="lbl">Hubungan</td><td class="sep">:</td>
        <td class="val">{{ $parent->hubungan_wali ?? '-' }}</td>
    </tr>
    <tr>
        <td class="lbl">Pendidikan</td><td class="sep">:</td>
        <td class="val">{{ $parent->pendidikan_wali ?? '-' }}</td>
        <td class="lbl">Pekerjaan</td><td class="sep">:</td>
        <td class="val">{{ $parent->pekerjaan_wali ?? '-' }}</td>
    </tr>
    @endif
</table>

{{-- ═══════════ PAGE BREAK ═══════════ --}}
<div class="page-break"></div>

{{-- ━━━━━━━━━━━━━━━━━ HALAMAN 2 ━━━━━━━━━━━━━━━━━ --}}

{{-- KOP mini halaman 2 --}}
<table class="kop" style="margin-bottom:4pt;">
    <tr>
        <td style="width:50pt;"><div class="kop-logo" style="width:32pt;height:32pt;line-height:32pt;font-size:11pt;">TK</div></td>
        <td class="kop-info">
            <p class="sekolah" style="font-size:10pt;">TK Puspitasari Kaliwatubumi</p>
            <p class="alamat">Lanjutan – Formulir Rekap PPDB (Halaman 2)</p>
        </td>
    </tr>
</table>
<div class="kop-border" style="margin-bottom:6pt;"></div>

{{-- C. DOKUMEN PERSYARATAN --}}
<div class="sec">C. Dokumen Persyaratan</div>

<table class="doc-outer">
    <tr>
        {{-- Akta Kelahiran --}}
        <td>
            <table class="doc-card" style="width:100%; border-collapse:collapse;">
                <tr><td class="doc-card-h">Akta Kelahiran *</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->akta_kelahiran && file_exists(public_path('storage/' . $doc->akta_kelahiran)))
                            @php $ext = strtolower(pathinfo($doc->akta_kelahiran, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ public_path('storage/' . $doc->akta_kelahiran) }}" alt="Akta">
                            @else
                                <span class="doc-miss">Berkas PDF<br>(Tersedia)</span>
                            @endif
                        @else
                            <span class="doc-miss">Belum<br>diunggah</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        {{-- Kartu Keluarga --}}
        <td>
            <table class="doc-card" style="width:100%; border-collapse:collapse;">
                <tr><td class="doc-card-h">Kartu Keluarga *</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->kartu_keluarga && file_exists(public_path('storage/' . $doc->kartu_keluarga)))
                            @php $ext = strtolower(pathinfo($doc->kartu_keluarga, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ public_path('storage/' . $doc->kartu_keluarga) }}" alt="KK">
                            @else
                                <span class="doc-miss">Berkas PDF<br>(Tersedia)</span>
                            @endif
                        @else
                            <span class="doc-miss">Belum<br>diunggah</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        {{-- Ijazah TK --}}
        <td>
            <table class="doc-card" style="width:100%; border-collapse:collapse;">
                <tr><td class="doc-card-h">Ijazah TK / PAUD</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->ijazah_tk && file_exists(public_path('storage/' . $doc->ijazah_tk)))
                            @php $ext = strtolower(pathinfo($doc->ijazah_tk, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ public_path('storage/' . $doc->ijazah_tk) }}" alt="Ijazah">
                            @else
                                <span class="doc-miss">Berkas PDF<br>(Tersedia)</span>
                            @endif
                        @else
                            <span class="doc-miss">Tidak<br>diunggah</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- Catatan Verifikasi --}}
@if($registration->notes)
<div class="sec" style="background:#6b7280; margin-top:10pt;">Catatan Verifikasi Admin</div>
<div class="catatan">{{ $registration->notes }}</div>
@endif

{{-- TANDA TANGAN --}}
<table class="ttd" style="margin-top:{{ $registration->notes ? '10pt' : '25pt' }};">
    <tr>
        <td>
            <div class="role">Orang Tua / Wali,</div>
            <div class="nama-line">{{ $parent?->nama_ayah ?? $parent?->nama_ibu ?? '( ............................. )' }}</div>
        </td>
        <td>
            <div class="role">
                Kaliwatubumi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <span style="font-weight:normal; font-size:8pt; color:#555;">Panitia PPDB TK Puspitasari</span>
            </div>
            <div class="nama-line">( ............................. )</div>
        </td>
    </tr>
</table>

<p style="text-align:center; font-size:7pt; color:#bbb; margin-top:18pt;">
    Halaman 2 dari 2 &nbsp;|&nbsp; PPDB TK Puspitasari Kaliwatubumi &nbsp;|&nbsp; Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
</p>

</body>
</html>
