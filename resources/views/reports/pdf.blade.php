<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPAD – {{ $report->lpadStudent->nama_lengkap }} – Semester {{ $report->semester }} – {{ $report->tahun_ajaran }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 10mm 15mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #111;
            margin: 0;
            padding: 0;
        }

        /* ─── PAGE LAYOUT ──────────────────────────────────────── */
        .page {
            width: 100%;
        }

        /* ─── KOP SURAT ────────────────────────────────────────── */
        .kop-table {
            width: 100%;
            border-bottom: 2pt double #1a1a6e;
            margin-bottom: 10pt;
        }
        .kop-table td { vertical-align: middle; }
        .kop-logo { width: 65pt; text-align: center; }
        .kop-logo img { width: 48pt; height: auto; }

        .kop-info { padding-left: 10pt; }
        .kop-info .nama-sekolah {
            font-size: 13pt;
            font-weight: bold;
            color: #1a1a6e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-info .npsn { font-size: 8pt; color: #555; margin-top: 1pt; }
        .kop-info .alamat { font-size: 8pt; color: #333; margin-top: 2pt; }

        /* ─── JUDUL DOKUMEN ────────────────────────────────────── */
        .doc-title-wrapper { text-align: center; margin: 8pt 0 4pt; }
        .doc-title {
            display: inline-block;
            font-size: 11pt;
            font-weight: bold;
            color: #fff;
            background-color: #1a1a6e;
            padding: 3.5pt 18pt;
            letter-spacing: 0.5px;
        }
        .doc-subtitle { font-size: 8pt; color: #444; margin-top: 3pt; }

        /* ─── BIODATA SISWA ────────────────────────────────────── */
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            background-color: #dce8ff;
            border-left: 3px solid #1a1a6e;
            padding: 2.5pt 7pt;
            margin-top: 8pt;
            margin-bottom: 5pt;
            color: #1a1a6e;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .biodata-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .biodata-table td { padding: 2.5pt 5pt; vertical-align: middle; }
        .biodata-table .label { width: 18%; color: #333; }
        .biodata-table .colon { width: 2%; text-align: center; }
        .biodata-table .value { width: 30%; font-weight: bold; color: #111; }

        /* ─── DATA TABLE (kesehatan, kehadiran) ────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 3pt;
        }
        .data-table th {
            background-color: #1a1a6e;
            color: #fff;
            padding: 4pt 6pt;
            text-align: center;
            font-weight: bold;
            font-size: 8.5pt;
        }
        .data-table td {
            padding: 3.5pt 6pt;
            border: 1px solid #c0cce8;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td { background-color: #f0f4ff; }
        .data-table .center { text-align: center; }
        .data-table .badge-baik    { color: #155724; background: #d4edda; padding: 1pt 4pt; border-radius: 2pt; font-size: 8.5pt; }
        .data-table .badge-cukup   { color: #856404; background: #fff3cd; padding: 1pt 4pt; border-radius: 2pt; font-size: 8.5pt; }
        .data-table .badge-perlu   { color: #721c24; background: #f8d7da; padding: 1pt 4pt; border-radius: 2pt; font-size: 8.5pt; }

        /* ─── NARASI CAPAIAN ───────────────────────────────────── */
        .narasi-wrapper {
            border: 1px solid #c0cce8;
            border-radius: 3pt;
            padding: 6pt 8pt;
            margin-top: 3pt;
            font-size: 9pt;
            background: #fafbff;
            min-height: 40pt;
        }
        .narasi-wrapper p    { margin-bottom: 3pt; }
        .narasi-wrapper ul,
        .narasi-wrapper ol   { margin-left: 15pt; margin-bottom: 3pt; }
        .narasi-wrapper li   { margin-bottom: 1.5pt; }
        .narasi-wrapper strong { color: #1a1a6e; }
        .narasi-empty { color: #999; font-style: italic; font-size: 8.5pt; }

        /* ─── KEHADIRAN HIGHLIGHT ──────────────────────────────── */
        .kehadiran-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 3pt;
        }
        .kehadiran-table td {
            border: 1px solid #c0cce8;
            padding: 5pt;
            text-align: center;
        }
        .kehadiran-table .kh-label { font-weight: bold; font-size: 8pt; color: #333; background: #dce8ff; }
        .kehadiran-table .kh-val   { font-size: 12pt; font-weight: bold; }
        .sakit-color  { color: #c0392b; }
        .izin-color   { color: #e67e22; }
        .alpa-color   { color: #8e44ad; }

        /* ─── KOMENTAR ORTU ────────────────────────────────────── */
        .komentar-box {
            border: 1px dashed #1a1a6e;
            padding: 6pt 8pt;
            margin-top: 3pt;
            min-height: 30pt;
            font-size: 9pt;
            background: #fafbff;
            font-style: italic;
            color: #333;
        }
        .komentar-empty { color: #aaa; font-style: italic; }

        /* ─── TANDA TANGAN ─────────────────────────────────────── */
        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 20pt; }
        .ttd-table td { width: 33.33%; text-align: center; vertical-align: top; font-size: 9pt; }
        .ttd-table .ttd-label { font-weight: bold; line-height: 1.4; }
        .ttd-table .ttd-signature-space { height: 50pt; }
        .ttd-table .ttd-name { font-weight: bold; text-decoration: underline; }

        /* ─── FOOTER ───────────────────────────────────────────── */
        .doc-footer {
            border-top: 1px solid #c0cce8;
            margin-top: 10pt;
            padding-top: 4pt;
            font-size: 8pt;
            color: #999;
            text-align: center;
        }

        /* ─── UTILITY ──────────────────────────────────────────── */
        .mt-6 { margin-top: 6pt; }
        .mt-10 { margin-top: 10pt; }
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
@php
    if (!function_exists('pdf_value')) {
        function pdf_value($value, $fallback = '—') {
            if (is_null($value)) {
                return $fallback;
            }
            $trimmed = trim(strip_tags($value));
            return (empty($trimmed) || $trimmed === '') ? $fallback : $value;
        }
    }
@endphp
<div class="page">

    {{-- ═══════════════════════════════════════════════════════════
         KOP SURAT
    ════════════════════════════════════════════════════════════════ --}}
    <table class="kop-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="kop-logo">
                @php
                    // Prioritas 1: logo dari identitas sekolah (storage)
                    $logoSrc = null;
                    if ($identity && $identity->logo) {
                        $idLogoPath = storage_path('app/public/' . $identity->logo);
                        if (file_exists($idLogoPath)) {
                            $logoSrc = 'file://' . $idLogoPath;
                        }
                    }
                    // Prioritas 2: logo bawaan TK di public/images/logo.png
                    if (!$logoSrc) {
                        $defLogo = realpath(public_path('images/logo.png'));
                        if ($defLogo && file_exists($defLogo)) {
                            $logoSrc = 'file://' . $defLogo;
                        }
                    }
                @endphp
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="Logo Sekolah">
                @else
                    <table width="65" height="65" style="border:2pt solid #1a1a6e;font-size:20pt;font-weight:bold;color:#1a1a6e;" cellpadding="0" cellspacing="0">
                        <tr><td align="center" valign="middle">TK</td></tr>
                    </table>
                @endif
            </td>
            <td class="kop-info">
                <div class="nama-sekolah">
                    {{ $identity->school_name ?? 'TAMAN KANAK-KANAK PUSPITASARI KALIWATUBUMI' }}
                </div>
                @if($identity && $identity->npsn)
                    <div class="npsn">NPSN: {{ $identity->npsn }}</div>
                @endif
                <div class="alamat">
                    Alamat: {{ $identity->address ?? 'Jalan Abean RT 01 RW 05 Desa Kaliwatubumi Kecamatan Butuh Kabupaten Purworejo Jawa Tengah Kode Pos 54264' }}
                    @if($identity && $identity->phone) &nbsp;| Telp: {{ $identity->phone }} @endif
                    @if($identity && $identity->email) &nbsp;| Email: {{ $identity->email }} @endif
                    @if($identity && $identity->website) &nbsp;| Website: {{ $identity->website }} @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- ═══════════════════════════════════════════════════════════
         JUDUL DOKUMEN
    ════════════════════════════════════════════════════════════════ --}}
    <div class="doc-title-wrapper">
        <div class="doc-title">LAPORAN PERKEMBANGAN ANAK DIDIK (LPAD)</div>
        <div class="doc-subtitle mt-6">
            Kurikulum Merdeka &nbsp;|&nbsp;
            Semester {{ $report->semester == '1' ? 'I (Ganjil)' : 'II (Genap)' }} &nbsp;|&nbsp;
            Tahun Ajaran {{ $report->tahun_ajaran }}
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         BIODATA SISWA
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">A. Identitas Peserta Didik</div>

    @php $s = $report->lpadStudent; @endphp

    <table class="biodata-table" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">Nama Lengkap</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">{{ $s->nama_lengkap }}</td>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">No. Induk</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">{{ $s->no_induk }}</td>
        </tr>
        <tr>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">Tanggal Lahir</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">{{ \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">Usia</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">
                @if($s && $s->tanggal_lahir)
                    {{ $s->getUsiaAt($report->created_at ?? now()) }}
                @else
                    —
                @endif
            </td>
        </tr>
        <tr>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">Tahun Ajaran</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">{{ $report->tahun_ajaran }}</td>
            <td class="label" style="width: 15%; font-weight: normal; color: #333; padding: 4pt 6pt; vertical-align: middle;">Semester</td>
            <td class="colon" style="width: 2%; text-align: center; padding: 4pt 6pt; vertical-align: middle;">:</td>
            <td class="value" style="width: 33%; font-weight: bold; color: #111; padding: 4pt 6pt; vertical-align: middle;">{{ $report->semester == '1' ? 'I (Ganjil)' : 'II (Genap)' }}</td>
        </tr>
    </table>

    {{-- ═══════════════════════════════════════════════════════════
         DATA FISIK
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">B. Data Fisik &amp; Antropometri</div>

    @php
        $bbDisplay = ($report->bb && $report->bb >= 5) ? number_format($report->bb, 1) : '—';
        $tbDisplay = ($report->tb && $report->tb >= 50) ? number_format($report->tb, 1) : '—';
        $lkDisplay = ($report->lingkar_kepala && $report->lingkar_kepala >= 30) ? number_format($report->lingkar_kepala, 1) : '—';
    @endphp

    <table class="data-table" cellpadding="0" cellspacing="0">
        <tr>
            <th>Berat Badan (kg)</th>
            <th>Tinggi Badan (cm)</th>
            <th>Lingkar Kepala (cm)</th>
        </tr>
        <tr>
            <td class="center bold">{{ $bbDisplay }}</td>
            <td class="center bold">{{ $tbDisplay }}</td>
            <td class="center bold">{{ $lkDisplay }}</td>
        </tr>
    </table>
    @if(($report->bb && $report->bb > 100) || ($report->tb && $report->tb > 0 && $report->tb < 50))
        <div style="color: #c0392b; font-size: 8.5pt; margin-top: 5pt; font-weight: bold; font-style: italic;">
            * Peringatan: Terdapat nilai antropometri yang tidak wajar 
            (@if($report->bb > 100) Berat Badan > 100 kg @endif
             @if($report->bb > 100 && $report->tb > 0 && $report->tb < 50) dan @endif
             @if($report->tb > 0 && $report->tb < 50) Tinggi Badan < 50 cm @endif)
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         KONDISI KESEHATAN
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">C. Kondisi Kesehatan</div>

    @php
        $kesehatanData = [
            'Mata'    => $report->kondisi_mata,
            'Telinga' => $report->kondisi_telinga,
            'Hidung'  => $report->kondisi_hidung,
            'Gigi'    => $report->kondisi_gigi,
            'Kulit'   => $report->kondisi_kulit,
        ];
        if (!function_exists('badgeClass')) {
            function badgeClass($val): string {
                $val = (string) $val;
                if (str_contains($val, 'Baik'))   return 'badge-baik';
                if (str_contains($val, 'Cukup'))  return 'badge-cukup';
                return 'badge-perlu';
            }
        }
    @endphp

    <table class="data-table" cellpadding="0" cellspacing="0">
        <tr>
            <th>Organ</th>
            <th>Kondisi</th>
            <th>Organ</th>
            <th>Kondisi</th>
        </tr>
        @foreach(array_chunk(array_keys($kesehatanData), 2, true) as $chunk)
        <tr>
            @foreach($chunk as $organ)
            <td>{{ $organ }}</td>
            <td class="center">
                @if(!empty(trim($kesehatanData[$organ] ?? '')))
                    <span class="{{ badgeClass($kesehatanData[$organ]) }}">{{ $kesehatanData[$organ] }}</span>
                @else
                    <span style="color: #999; font-style: italic;">Data belum tersedia</span>
                @endif
            </td>
            @endforeach
            @if(count($chunk) == 1)
            <td colspan="2"></td>
            @endif
        </tr>
        @endforeach
    </table>

    {{-- ═══════════════════════════════════════════════════════════
         REKAP KEHADIRAN
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">D. Rekap Kehadiran</div>

    <table class="kehadiran-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="kh-label">Sakit (hari)</td>
            <td class="kh-label">Izin (hari)</td>
            <td class="kh-label">Alpa (hari)</td>
            <td class="kh-label">Total Tidak Hadir</td>
        </tr>
        <tr>
            <td class="kh-val sakit-color">{{ $report->sakit }}</td>
            <td class="kh-val izin-color">{{ $report->izin }}</td>
            <td class="kh-val alpa-color">{{ $report->alpa }}</td>
            <td class="kh-val bold">{{ $report->sakit + $report->izin + $report->alpa }}</td>
        </tr>
    </table>

    {{-- ═══════════════════════════════════════════════════════════
         NARASI CAPAIAN PEMBELAJARAN
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">E. Capaian Pembelajaran (Narasi)</div>

    @php 
        $narasi = $report->narrative; 

        $narasiAgama = $narasi?->elemen_agama_budi_pekerti;
        if (empty(trim(strip_tags($narasiAgama)))) {
            $narasiAgama = \App\Services\NarrativeGenerator::generate($s, 'nilai_agama_budi_pekerti');
        }

        $narasiJatiDiri = $narasi?->elemen_jati_diri;
        if (empty(trim(strip_tags($narasiJatiDiri)))) {
            $narasiJatiDiri = \App\Services\NarrativeGenerator::generate($s, 'jati_diri');
        }

        $narasiSteam = $narasi?->elemen_literasi_steam;
        if (empty(trim(strip_tags($narasiSteam)))) {
            $narasiSteam = \App\Services\NarrativeGenerator::generate($s, 'dasar_literasi_steam');
        }
    @endphp

    {{-- E.1 Agama & Budi Pekerti --}}
    <div class="bold mt-6">E.1 &nbsp; Elemen Agama &amp; Budi Pekerti</div>
    <div class="narasi-wrapper">
        {!! pdf_value($narasiAgama, '<span class="narasi-empty">Perkembangan Ananda masih dalam tahap observasi guru.</span>') !!}
    </div>

    {{-- E.2 Jati Diri --}}
    <div class="bold mt-6">E.2 &nbsp; Elemen Jati Diri</div>
    <div class="narasi-wrapper">
        {!! pdf_value($narasiJatiDiri, '<span class="narasi-empty">Perkembangan Ananda masih dalam tahap observasi guru.</span>') !!}
    </div>

    {{-- E.3 Literasi & STEAM --}}
    <div class="bold mt-6">E.3 &nbsp; Elemen Literasi &amp; STEAM</div>
    <div class="narasi-wrapper">
        {!! pdf_value($narasiSteam, '<span class="narasi-empty">Perkembangan Ananda masih dalam tahap observasi guru.</span>') !!}
    </div>

    {{-- E.4 Projek P5 --}}
    <div class="bold mt-6">E.4 &nbsp; Projek Penguatan Profil Pelajar Pancasila (P5)</div>
    <div class="narasi-wrapper">
        {!! pdf_value($narasi?->projek_p5, '<span class="narasi-empty">Perkembangan Ananda masih dalam tahap observasi guru.</span>') !!}
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         KOMENTAR ORANG TUA
    ════════════════════════════════════════════════════════════════ --}}
    <div class="section-title">F. Komentar / Harapan Orang Tua</div>
    <div class="komentar-box">
        {!! pdf_value($report->komentar_ortu, '<span class="komentar-empty">Data belum tersedia</span>') !!}
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TANDA TANGAN
    ════════════════════════════════════════════════════════════════ --}}
    <table class="ttd-table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="ttd-label">Mengetahui,<br>Kepala Sekolah</div>
                <div class="ttd-signature-space"></div>
                <div class="ttd-name">{{ $identity->headmaster ?? '....................................' }}</div>
            </td>
            <td>
                <div class="ttd-label">Guru Kelas<br><span style="visibility:hidden;">.</span></div>
                <div class="ttd-signature-space"></div>
                <div class="ttd-name">{{ $identity->operator ?? '....................................' }}</div>
            </td>
            <td>
                <div class="ttd-label">
                    Orang Tua / Wali,<br>
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
                <div class="ttd-signature-space"></div>
                <div class="ttd-name">....................................</div>
            </td>
        </tr>
    </table>

    {{-- ─── Footer ──────────────────────────────────────────── --}}
    <div class="doc-footer">
        Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
        &nbsp;|&nbsp; LPAD Kurikulum Merdeka &nbsp;|&nbsp; {{ $identity->nama_sekolah ?? 'TK Puspitasari' }}
    </div>

</div>
</body>
</html>
