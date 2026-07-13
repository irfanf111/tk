<?php

namespace App\Http\Controllers;

use App\Models\LpadStudent;
use App\Models\Report;
use App\Models\ReportNarrative;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Tampilkan form pembuatan laporan baru.
     * Kirim juga daftar siswa untuk dropdown.
     */
    public function create()
    {
        $students = LpadStudent::orderBy('nama_lengkap')->get();

        return view('reports.create', compact('students'));
    }

    /**
     * Simpan laporan baru beserta narasinya ke dalam database.
     * Menggunakan DB Transaction agar data atomik (all-or-nothing).
     */
    public function store(Request $request)
    {
        // ── Validasi ────────────────────────────────────────────────────────────
        $validated = $request->validate([
            'lpad_student_id'           => 'required|exists:lpad_students,id',
            'tahun_ajaran'              => 'required|string|max:20',
            'semester'                  => 'required|in:1,2',
            'bb'                        => 'required|numeric|min:0',
            'tb'                        => 'required|numeric|min:0',
            'lingkar_kepala'            => 'required|numeric|min:0',
            'kondisi_mata'              => 'required|string|max:100',
            'kondisi_telinga'           => 'required|string|max:100',
            'kondisi_hidung'            => 'required|string|max:100',
            'kondisi_gigi'              => 'required|string|max:100',
            'kondisi_kulit'             => 'required|string|max:100',
            'sakit'                     => 'required|integer|min:0',
            'izin'                      => 'required|integer|min:0',
            'alpa'                      => 'required|integer|min:0',
            'komentar_ortu'             => 'nullable|string',
            'elemen_agama_budi_pekerti' => 'nullable|string',
            'elemen_jati_diri'          => 'nullable|string',
            'elemen_literasi_steam'     => 'nullable|string',
            'projek_p5'                 => 'nullable|string',
        ], [
            'lpad_student_id.required' => 'Siswa wajib dipilih.',
            'lpad_student_id.exists'   => 'Siswa tidak ditemukan di database.',
            'semester.in'              => 'Semester hanya boleh bernilai 1 atau 2.',
        ]);

        // ── DB Transaction ──────────────────────────────────────────────────────
        DB::transaction(function () use ($validated) {
            // 1. Simpan data laporan utama
            $report = Report::create([
                'lpad_student_id' => $validated['lpad_student_id'],
                'tahun_ajaran'    => $validated['tahun_ajaran'],
                'semester'        => $validated['semester'],
                'bb'              => $validated['bb'],
                'tb'              => $validated['tb'],
                'lingkar_kepala'  => $validated['lingkar_kepala'],
                'kondisi_mata'    => $validated['kondisi_mata'],
                'kondisi_telinga' => $validated['kondisi_telinga'],
                'kondisi_hidung'  => $validated['kondisi_hidung'],
                'kondisi_gigi'    => $validated['kondisi_gigi'],
                'kondisi_kulit'   => $validated['kondisi_kulit'],
                'sakit'           => $validated['sakit'],
                'izin'            => $validated['izin'],
                'alpa'            => $validated['alpa'],
                'komentar_ortu'   => $validated['komentar_ortu'] ?? null,
            ]);

            // 2. Simpan narasi capaian pembelajaran (relasi hasOne)
            ReportNarrative::create([
                'report_id'                 => $report->id,
                'elemen_agama_budi_pekerti' => $validated['elemen_agama_budi_pekerti'] ?? null,
                'elemen_jati_diri'          => $validated['elemen_jati_diri'] ?? null,
                'elemen_literasi_steam'     => $validated['elemen_literasi_steam'] ?? null,
                'projek_p5'                 => $validated['projek_p5'] ?? null,
            ]);
        });

        return redirect()
            ->route('reports.create')
            ->with('success', 'Laporan berhasil disimpan!');
    }

    /**
     * Export laporan sebagai PDF menggunakan barryvdh/laravel-dompdf.
     *
     * @param  int  $id  ID dari tabel reports
     */
    public function exportPdf(int $id)
    {
        $report = Report::with(['lpadStudent', 'narrative'])->findOrFail($id);

        // Ambil data identitas sekolah jika ada
        $identity = \App\Models\SchoolIdentity::first();

        $pdf = Pdf::loadView('reports.pdf', compact('report', 'identity'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif',
                'dpi'                  => 96,
                'chroot'               => base_path(),
            ]);

        $filename = 'LPAD_' . str_replace(' ', '_', $report->lpadStudent->nama_lengkap)
            . '_Sem' . $report->semester
            . '_' . $report->tahun_ajaran
            . '.pdf';

        return $pdf->download($filename);
    }
}
