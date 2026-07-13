<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir PPDB – {{ $registration->nama_terpadu }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Times New Roman',Times,serif; font-size:10.5pt; color:#111; background:#fff; line-height:1.45; }
        .page { width:100%; padding:14mm 14mm 14mm 20mm; }

        /* KOP SURAT */
        .kop { width:100%; border-bottom:4px double #1a1a6e; margin-bottom:10pt; }
        .kop td { vertical-align:middle; }
        .kop-logo { width:72pt; text-align:center; }
        .kop-logo-box { width:60pt; height:60pt; border:2px solid #1a1a6e; border-radius:50%; display:table-cell; vertical-align:middle; text-align:center; font-size:18pt; font-weight:bold; color:#1a1a6e; }
        .kop-info { padding-left:10pt; }
        .kop-nama { font-size:15pt; font-weight:bold; color:#1a1a6e; text-transform:uppercase; letter-spacing:1px; }
        .kop-sub  { font-size:8.5pt; color:#444; margin-top:2pt; }

        /* JUDUL */
        .judul-wrapper { text-align:center; margin:8pt 0 5pt; }
        .judul { display:inline-block; font-size:12pt; font-weight:bold; background:#1a1a6e; color:#fff; padding:3pt 18pt; letter-spacing:1px; }
        .judul-sub { font-size:8.5pt; color:#555; margin-top:3pt; }

        /* NO PENDAFTARAN BADGE */
        .no-badge-table { width:100%; margin-bottom:8pt; }
        .no-badge { background:#f0f4ff; border:1px solid #b0c4e8; padding:4pt 8pt; font-size:9.5pt; color:#1a1a6e; font-weight:bold; }

        /* SECTION TITLE */
        .sec-title { font-size:9.5pt; font-weight:bold; background:#dce8ff; border-left:4px solid #1a1a6e; padding:3pt 8pt; margin:8pt 0 5pt; color:#1a1a6e; text-transform:uppercase; letter-spacing:0.4px; }

        /* DATA ROWS */
        .data-tbl { width:100%; border-collapse:collapse; font-size:10pt; }
        .data-tbl td { padding:3pt 5pt; vertical-align:top; }
        .data-tbl .lbl { width:34%; color:#333; }
        .data-tbl .sep { width:3%; text-align:center; }
        .data-tbl .val { font-weight:bold; }

        /* DIVIDER LINE */
        .divider { border:none; border-top:1px solid #c0cce8; margin:6pt 0; }

        /* STATUS BADGE */
        .status-pending  { color:#7c3aed; background:#ede9fe; padding:2pt 6pt; border-radius:3pt; font-size:9pt; font-weight:bold; }

        /* TTD */
        .ttd-tbl { width:100%; border-collapse:collapse; margin-top:22pt; }
        .ttd-tbl td { width:50%; text-align:center; vertical-align:top; padding:5pt; font-size:10pt; }
        .ttd-label { font-weight:bold; margin-bottom:50pt; display:block; }
        .ttd-line { border-top:1px solid #333; display:inline-block; min-width:110pt; padding-top:3pt; }

        /* FOOTER */
        .doc-footer { border-top:1px solid #ddd; margin-top:10pt; padding-top:4pt; font-size:8pt; color:#aaa; text-align:center; }

        /* HELPER */
        .mt4 { margin-top:4pt; }
        .bold { font-weight:bold; }
        .center { text-align:center; }
    </style>
</head>
<body>
<div class="page">

    {{-- KOP --}}
    <table class="kop" cellpadding="0" cellspacing="0">
        <tr>
            <td class="kop-logo" style="width: 60pt; text-align: center;">
                @php
                    $logoSrc = null;
                    if ($identity && $identity->logo) {
                        $idLogoPath = storage_path('app/public/' . $identity->logo);
                        if (file_exists($idLogoPath)) {
                            $logoSrc = 'file://' . $idLogoPath;
                        }
                    }
                    if (!$logoSrc) {
                        $defLogo = realpath(public_path('images/logo.png'));
                        if ($defLogo && file_exists($defLogo)) {
                            $logoSrc = 'file://' . $defLogo;
                        }
                    }
                @endphp
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" style="width: 50pt; height: 50pt;" alt="Logo School">
                @else
                    <table width="50" height="50" style="border:2px solid #1a1a6e;border-radius:50%;" cellpadding="0" cellspacing="0">
                        <tr><td class="center bold" style="font-size:14pt;color:#1a1a6e;">TK</td></tr>
                    </table>
                @endif
            </td>
            <td class="kop-info">
                <div class="kop-nama">{{ $identity->school_name ?? 'TK Puspitasari' }}</div>
                @if($identity?->npsn)<div class="kop-sub">NPSN: {{ $identity->npsn }}</div>@endif
                <div class="kop-sub">{{ $identity->address ?? '' }}{{ $identity?->regency ? ', '.$identity->regency : '' }}{{ $identity?->province ? ', '.$identity->province : '' }}</div>
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="judul-wrapper">
        <div class="judul">FORMULIR PENDAFTARAN PPDB</div>
        <div class="judul-sub">Penerimaan Peserta Didik Baru · Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}</div>
    </div>

    {{-- NO PENDAFTARAN --}}
    <table class="no-badge-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="no-badge">No. Pendaftaran: {{ $registration->nomor_pendaftaran ?? $registration->no_pendaftaran }}</td>
            <td style="text-align:right;font-size:9pt;color:#555;">
                Tgl. Daftar: {{ \Carbon\Carbon::parse($registration->created_at)->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    {{-- ═══════════════ SECTION A: KETERANGAN SISWA ════════════════ --}}
    <div class="sec-title">A. Keterangan Siswa</div>

    <table class="data-tbl" cellpadding="0" cellspacing="0">
        <tr>
            <td class="lbl">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->nama_terpadu }}</td>
            <td class="lbl">Nama Panggilan</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->nama_panggilan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Jenis Kelamin</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="lbl">Agama</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Tempat, Tgl. Lahir</td>
            <td class="sep">:</td>
            <td class="val" colspan="3">
                {{ $registration->tempat_lahir }},
                {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="lbl">Kewarganegaraan</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->kewarganegaraan ?? 'WNI' }}</td>
            <td class="lbl">Bahasa Sehari-hari</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->bahasa_sehari_hari ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Anak ke-</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->anak_ke ?? '-' }}</td>
            <td class="lbl">Tinggal Bersama</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->tinggal_bersama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Saudara Kandung</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->jml_saudara_kandung ?? 0 }} orang</td>
            <td class="lbl">Saudara Tiri / Angkat</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->jml_saudara_tiri ?? 0 }} / {{ $registration->jml_saudara_angkat ?? 0 }} orang</td>
        </tr>
        <tr>
            <td class="lbl">Berat / Tinggi Badan</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->berat_badan ?? '-' }} kg / {{ $registration->tinggi_badan ?? '-' }} cm</td>
            <td class="lbl">Golongan Darah</td>
            <td class="sep">:</td>
            <td class="val">{{ $registration->golongan_darah ?? 'Belum diketahui' }}</td>
        </tr>
        <tr>
            <td class="lbl">Riwayat Penyakit</td>
            <td class="sep">:</td>
            <td class="val" colspan="3">{{ $registration->riwayat_penyakit ?: 'Tidak ada' }}</td>
        </tr>
        <tr>
            <td class="lbl">No. HP / WhatsApp</td>
            <td class="sep">:</td>
            <td class="val" colspan="3">{{ $registration->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Alamat Lengkap</td>
            <td class="sep">:</td>
            <td class="val" colspan="3">{{ $registration->alamat_terpadu }}</td>
        </tr>
    </table>

    {{-- ═════════════ SECTION B: ORANG TUA / WALI ═════════════════ --}}
    <div class="sec-title">B. Orang Tua / Wali Murid</div>

    {{-- Tabel 3 kolom: Ayah | Ibu | Wali --}}
    <table class="data-tbl" style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:33%;padding:4pt 6pt;vertical-align:top;">
                <div class="bold" style="color:#1a1a6e;border-bottom:1px solid #dce8ff;padding-bottom:2pt;margin-bottom:4pt;">Ayah</div>
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:9.5pt;">
                    <tr><td style="color:#555;width:45%;">Nama</td><td>:</td><td class="bold">{{ $registration->nama_ayah ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Tempat, Tgl. Lahir</td><td>:</td><td>{{ $registration->tempat_lahir_ayah ?? '-' }}{{ $registration->tanggal_lahir_ayah ? ', '.\Carbon\Carbon::parse($registration->tanggal_lahir_ayah)->translatedFormat('d/m/Y') : '' }}</td></tr>
                    <tr><td style="color:#555;">Pendidikan</td><td>:</td><td>{{ $registration->pendidikan_ayah ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Pekerjaan</td><td>:</td><td>{{ $registration->pekerjaan_ayah ?? '-' }}</td></tr>
                </table>
            </td>
            <td style="width:33%;padding:4pt 6pt;vertical-align:top;border-left:1px solid #dce8ff;border-right:1px solid #dce8ff;">
                <div class="bold" style="color:#1a1a6e;border-bottom:1px solid #dce8ff;padding-bottom:2pt;margin-bottom:4pt;">Ibu</div>
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:9.5pt;">
                    <tr><td style="color:#555;width:45%;">Nama</td><td>:</td><td class="bold">{{ $registration->nama_ibu ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Tempat, Tgl. Lahir</td><td>:</td><td>{{ $registration->tempat_lahir_ibu ?? '-' }}{{ $registration->tanggal_lahir_ibu ? ', '.\Carbon\Carbon::parse($registration->tanggal_lahir_ibu)->translatedFormat('d/m/Y') : '' }}</td></tr>
                    <tr><td style="color:#555;">Pendidikan</td><td>:</td><td>{{ $registration->pendidikan_ibu ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Pekerjaan</td><td>:</td><td>{{ $registration->pekerjaan_ibu ?? '-' }}</td></tr>
                </table>
            </td>
            <td style="width:34%;padding:4pt 6pt;vertical-align:top;">
                <div class="bold" style="color:#1a1a6e;border-bottom:1px solid #dce8ff;padding-bottom:2pt;margin-bottom:4pt;">Wali</div>
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:9.5pt;">
                    <tr><td style="color:#555;width:45%;">Nama</td><td>:</td><td class="bold">{{ $registration->nama_wali ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Hubungan</td><td>:</td><td>{{ $registration->hubungan_anak_wali ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Pendidikan</td><td>:</td><td>{{ $registration->pendidikan_wali ?? '-' }}</td></tr>
                    <tr><td style="color:#555;">Pekerjaan</td><td>:</td><td>{{ $registration->pekerjaan_wali ?? '-' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ═════════════ PERNYATAAN ════════════════════════════════════ --}}
    <div class="sec-title">C. Pernyataan</div>
    <p style="font-size:9.5pt;line-height:1.6;color:#333;">
        Dengan ini saya menyatakan bahwa data yang diisikan di atas adalah <b>benar adanya</b> dan dapat
        dipertanggungjawabkan. Apabila di kemudian hari terdapat ketidaksesuaian data, saya bersedia menerima
        konsekuensi yang berlaku sesuai peraturan <b>{{ $identity->school_name ?? 'TK Puspitasari' }}</b>.
    </p>

    {{-- ═════════════ TANDA TANGAN ══════════════════════════════════ --}}
    <table class="ttd-tbl" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <span class="ttd-label">Orang Tua / Wali,</span>
                <br><br><br><br><br>
                <span class="ttd-line">( ....................................... )</span>
            </td>
            <td>
                <span class="ttd-label">
                    {{ $identity->address ? explode(',', $identity->address)[0] : '.................' }},
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Kepala Sekolah,
                </span>
                <br><br><br><br><br>
                <span class="ttd-line">( ....................................... )</span>
            </td>
        </tr>
    </table>

    <div class="doc-footer">
        Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
        &nbsp;|&nbsp; Formulir PPDB · {{ $identity->school_name ?? 'TK Puspitasari' }}
        &nbsp;|&nbsp; No. Pendaftaran: {{ $registration->nomor_pendaftaran ?? $registration->no_pendaftaran }}
    </div>

</div>
</body>
</html>
