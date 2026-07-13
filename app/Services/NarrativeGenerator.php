<?php

namespace App\Services;

use App\Models\CatatanPerkembangan;
use App\Models\LpadStudent;

class NarrativeGenerator
{
    /**
     * Membuat narasi per elemen kurikulum untuk satu LPAD Student.
     */
    public static function generate(LpadStudent $lpadStudent, string $elemen): string
    {
        $siswaId = $lpadStudent->student_id;

        if (!$siswaId) {
            return "Perkembangan Ananda {$lpadStudent->nama_lengkap} masih dalam tahap observasi guru.";
        }

        $catatans = CatatanPerkembangan::with('kompetensi')
            ->where('siswa_id', $siswaId)
            ->whereHas('kompetensi', fn($q) => $q->where('elemen', $elemen))
            ->get();

        if ($catatans->isEmpty()) {
            return "Perkembangan Ananda {$lpadStudent->nama_lengkap} masih dalam tahap observasi guru.";
        }

        // Pengelompokan data pencapaian
        $optimal = $catatans->where('status_pencapaian', 'Optimal');
        $bimbingan = $catatans->where('status_pencapaian', 'Perlu Bimbingan');

        $narasi = "";
        $namaPanggilan = $lpadStudent->student?->nama_panggilan ?? $lpadStudent->nama_lengkap;

        // 1. GENERATE CAPAIAN OPTIMAL
        if ($optimal->isNotEmpty()) {
            $pembukaOptimal = [
                "Alhamdulillah, pada semester ini Ananda {$namaPanggilan} menunjukkan perkembangan yang sangat baik. Ia telah mampu ",
                "Dalam elemen ini, {$namaPanggilan} menunjukkan pencapaian yang optimal. Ananda terlihat mahir dalam ",
                "Kemampuan {$namaPanggilan} berkembang dengan luar biasa. Ananda sudah sangat baik dalam hal "
            ];
            // Gunakan seed agar random tetapi konsisten untuk data yang sama
            $seedIndex = crc32($lpadStudent->id . $elemen) % count($pembukaOptimal);
            $narasi .= $pembukaOptimal[abs($seedIndex)];

            // Menggabungkan teks TP standar
            $tpOptimalTexts = $optimal->map(fn($c) => lcfirst(rtrim($c->kompetensi->name, '.')))->toArray();
            
            if (count($tpOptimalTexts) === 1) {
                $narasi .= $tpOptimalTexts[0];
            } else {
                $lastTp = array_pop($tpOptimalTexts);
                $narasi .= implode(', ', $tpOptimalTexts) . ' serta ' . $lastTp;
            }

            // Gabungkan catatan khusus guru jika ada
            $catatanOptimalGuru = $optimal->filter(fn($c) => !empty(trim($c->catatan_khusus ?? '')))->map(fn($c) => trim($c->catatan_khusus))->toArray();
            if (!empty($catatanOptimalGuru)) {
                $narasi .= ". Hal ini terlihat dari catatan guru bahwa " . implode(' Selain itu, ', $catatanOptimalGuru);
            }
            $narasi .= ". ";
        }

        // 2. GENERATE BUTUH BIMBINGAN / STIMULUS
        if ($bimbingan->isNotEmpty()) {
            $transisiBimbingan = [
                "Untuk mendukung kemampuannya agar lebih optimal, diharapkan Ananda {$namaPanggilan} mendapatkan stimulus lebih lanjut dalam hal ",
                "Di sisi lain, guru terus berusaha membimbing {$namaPanggilan} untuk meningkatkan kemampuannya dalam ",
                "Beberapa hal yang masih memerlukan bimbingan dan stimulus di sekolah maupun di rumah adalah kemampuan untuk "
            ];
            $seedIndex = crc32($lpadStudent->id . $elemen . 'bimbingan') % count($transisiBimbingan);
            $narasi .= $transisiBimbingan[abs($seedIndex)];

            // Menggabungkan teks TP bimbingan
            $tpBimbinganTexts = $bimbingan->map(fn($c) => lcfirst(rtrim($c->kompetensi->name, '.')))->toArray();

            if (count($tpBimbinganTexts) === 1) {
                $narasi .= $tpBimbinganTexts[0];
            } else {
                $lastBimbingan = array_pop($tpBimbinganTexts);
                $narasi .= implode(', ', $tpBimbinganTexts) . ' dan ' . $lastBimbingan;
            }

            // Gabungkan catatan khusus bimbingan jika ada
            $catatanBimbinganGuru = $bimbingan->filter(fn($c) => !empty(trim($c->catatan_khusus ?? '')))->map(fn($c) => trim($c->catatan_khusus))->toArray();
            if (!empty($catatanBimbinganGuru)) {
                $narasi .= ", terutama untuk catatan khusus guru: " . implode(' Serta, ', $catatanBimbinganGuru);
            }
            $narasi .= ". ";
        }

        return rtrim($narasi);
    }
}
