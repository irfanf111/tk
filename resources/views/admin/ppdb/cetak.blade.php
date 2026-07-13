<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pendaftaran – {{ $student?->nama_lengkap ?? 'N/A' }}</title>
    <style>
        @page { size: A4; margin: 12mm 15mm; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 9.5pt; line-height: 1.4; color: #111; background: #e5e7eb; }

        /* ── Tombol Aksi (tidak dicetak) ── */
        .no-print {
            text-align: center; padding: 14px; background: #1f2937;
            border-bottom: 1px solid #374151; position: sticky; top: 0; z-index: 100;
        }
        .btn-print { background: #16a34a; color: #fff; border: none; padding: 9px 24px; font-size: 13px; border-radius: 7px; cursor: pointer; font-weight: bold; margin-right: 6px; }
        .btn-pdf   { display: inline-block; background: #1e40af; color: #fff; text-decoration: none; padding: 9px 24px; font-size: 13px; border-radius: 7px; font-weight: bold; margin-right: 6px; }
        .btn-back  { background: #4b5563; color: #fff; border: none; padding: 9px 18px; font-size: 13px; border-radius: 7px; cursor: pointer; }

        /* ── Wrapper kertas A4 ── */
        .paper {
            max-width: 210mm;
            margin: 20px auto;
            background: #fff;
            padding: 12mm 15mm;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }

        /* ─── KOP SURAT ─────────────────────────────── */
        .kop { width: 100%; border-collapse: collapse; margin-bottom: 4pt; }
        .kop td { vertical-align: middle; padding: 0; }
        .kop-logo-img { width: 46pt; height: auto; }
        .kop-info { padding-left: 10pt; }
        .kop-info .sekolah { font-size: 13pt; font-weight: bold; color: #111; margin: 0 0 1pt 0; text-transform: uppercase; }
        .kop-info .alamat { font-size: 7.5pt; color: #444; margin: 0; }
        .kop-border { border-bottom: 2pt solid #111; margin-bottom: 6pt; }

        /* ─── JUDUL ─────────────────────────────────── */
        .judul { text-align: center; font-size: 10.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5pt; margin-bottom: 8pt; color: #111; }

        /* ─── INFO BAR ──────────────────────────────── */
        .infobar { width: 100%; border-collapse: collapse; background: #f4f4f4; border: 1pt solid #bbb; margin-bottom: 10pt; }
        .infobar td { padding: 5pt 8pt; vertical-align: top; }
        .infobar .lbl { font-size: 7pt; color: #555; text-transform: uppercase; }
        .infobar .val { font-size: 9pt; font-weight: bold; color: #111; }

        /* ─── SECTION HEADING ───────────────────────── */
        .sec { background: #333; color: #fff; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; padding: 3.5pt 7pt; margin: 8pt 0 4pt 0; }

        /* ─── DATA TABLE ────────────────────────────── */
        .dt { width: 100%; border-collapse: collapse; margin-bottom: 4pt; }
        .dt td { padding: 2.5pt 3pt; vertical-align: top; border-bottom: 0.5pt dashed #ccc; }
        .dt tr:last-child td { border-bottom: none; }
        .dt .lbl { font-weight: bold; color: #444; width: 22%; }
        .dt .sep { width: 2%; }
        .dt .val { color: #111; }
        .dt .sub { font-size: 8pt; font-weight: bold; color: #111; padding: 4pt 3pt 1pt; border-bottom: none; text-decoration: underline; }

        /* ─── DOKUMEN CARDS ─────────────────────────── */
        .doc-outer { width: 100%; border-collapse: collapse; margin-top: 4pt; }
        .doc-outer td { width: 33.33%; padding: 4pt; vertical-align: top; }
        .doc-card { border: 1pt solid #888; width: 100%; border-collapse: collapse; }
        .doc-card-h { background: #e8e8e8; font-weight: bold; font-size: 7.5pt; color: #111; padding: 3.5pt 5pt; border-bottom: 1pt solid #888; text-align: center; }
        .doc-card-b { padding: 5pt; text-align: center; min-height: 100pt; display: flex; align-items: center; justify-content: center; }
        .doc-img { max-width: 100%; max-height: 90pt; object-fit: contain; }
        .doc-miss { font-size: 7.5pt; color: #888; font-style: italic; }

        /* ─── TANDA TANGAN ──────────────────────────── */
        .ttd { width: 100%; border-collapse: collapse; margin-top: 20pt; }
        .ttd td { width: 50%; text-align: center; padding: 0 10pt; }
        .ttd .role { font-size: 8.5pt; font-weight: bold; margin-bottom: 40pt; }
        .ttd .nama-line { border-top: 1pt solid #111; font-size: 8.5pt; font-weight: bold; padding-top: 3pt; min-width: 120pt; display: inline-block; }

        /* ─── CATATAN ───────────────────────────────── */
        .catatan { border: 1pt solid #ccc; background: #f9f9f9; padding: 5pt 8pt; font-size: 8pt; color: #444; margin-bottom: 6pt; }

        /* ─── PAGE BREAK ────────────────────────────── */
        .page-break { page-break-after: always; }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .paper { max-width: 100%; margin: 0; padding: 0; box-shadow: none; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Print (Ctrl+P)</button>
    <a href="{{ route('admin.ppdb.pdf', $registration->id) }}" class="btn-pdf">📥 Unduh PDF (A4)</a>
    <button class="btn-back"  onclick="window.close()">✕ Tutup Tab</button>
</div>

<div class="paper">

{{-- ━━━━━━━━━━━━━━━━━ HALAMAN 1 ━━━━━━━━━━━━━━━━━ --}}

{{-- KOP --}}
@php
    $identity = \App\Models\SchoolIdentity::first();
    $logoPath = realpath(public_path('images/logo.png'));
@endphp
<table class="kop">
    <tr>
        <td style="width:50pt;">
            @if($logoPath && file_exists($logoPath))
                <img class="kop-logo-img" src="{{ public_path('images/logo.png') }}" alt="Logo TK Puspitasari">
            @else
                <div style="width:44pt;height:44pt;background:#333;color:#fff;font-size:14pt;font-weight:bold;text-align:center;line-height:44pt;">TK</div>
            @endif
        </td>
        <td class="kop-info">
            <p class="sekolah">{{ $identity->school_name ?? 'TK Puspitasari Kaliwatubumi' }}</p>
            <p class="alamat">Penerimaan Peserta Didik Baru (PPDB)</p>
            <p class="alamat">Alamat: {{ $identity->address ?? 'Kaliwatubumi, Kec. Butuh, Kabupaten Purworejo, Jawa Tengah' }}</p>
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
    <tr><td colspan="6" class="sub">Data Ibu</td></tr>
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
    @if($parent?->nama_wali)
    <tr><td colspan="6" class="sub">Data Wali</td></tr>
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

{{-- PAGE BREAK --}}
<div class="page-break"></div>

{{-- ━━━━━━━━━━━━━━━━━ HALAMAN 2 ━━━━━━━━━━━━━━━━━ --}}

{{-- KOP mini halaman 2 --}}
<table class="kop" style="margin-bottom:4pt;">
    <tr>
        <td style="width:40pt;">
            @if($logoPath && file_exists($logoPath))
                <img style="width:36pt;height:auto;" src="{{ public_path('images/logo.png') }}" alt="Logo TK">
            @else
                <div style="width:36pt;height:36pt;line-height:36pt;background:#333;color:#fff;font-size:11pt;font-weight:bold;text-align:center;">TK</div>
            @endif
        </td>
        <td class="kop-info">
            <p class="sekolah" style="font-size:10pt;">{{ $identity->school_name ?? 'TK Puspitasari Kaliwatubumi' }}</p>
            <p class="alamat">Lanjutan Formulir Rekap PPDB – Halaman 2 dari 2</p>
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
            <table class="doc-card">
                <tr><td class="doc-card-h">Akta Kelahiran *</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->akta_kelahiran)
                            @php $ext = strtolower(pathinfo($doc->akta_kelahiran, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ asset('storage/' . $doc->akta_kelahiran) }}" alt="Akta Kelahiran">
                            @else
                                <span class="doc-miss">Berkas PDF<br>Tersedia</span>
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
            <table class="doc-card">
                <tr><td class="doc-card-h">Kartu Keluarga *</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->kartu_keluarga)
                            @php $ext = strtolower(pathinfo($doc->kartu_keluarga, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ asset('storage/' . $doc->kartu_keluarga) }}" alt="Kartu Keluarga">
                            @else
                                <span class="doc-miss">Berkas PDF<br>Tersedia</span>
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
            <table class="doc-card">
                <tr><td class="doc-card-h">Ijazah TK / PAUD</td></tr>
                <tr>
                    <td class="doc-card-b">
                        @if($doc?->ijazah_tk)
                            @php $ext = strtolower(pathinfo($doc->ijazah_tk, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                <img class="doc-img" src="{{ asset('storage/' . $doc->ijazah_tk) }}" alt="Ijazah TK">
                            @else
                                <span class="doc-miss">Berkas PDF<br>Tersedia</span>
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
<div class="sec" style="background:#555; margin-top:10pt;">Catatan Verifikasi Admin</div>
<div class="catatan">{{ $registration->notes }}</div>
@endif

{{-- TANDA TANGAN --}}
<table class="ttd" style="margin-top:20pt;">
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

<p style="text-align:center; font-size:7pt; color:#aaa; margin-top:20pt;">
    Halaman 2 dari 2 &nbsp;|&nbsp; PPDB TK Puspitasari Kaliwatubumi &nbsp;|&nbsp; Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
</p>

</div>{{-- end .paper --}}
</body>
</html>
