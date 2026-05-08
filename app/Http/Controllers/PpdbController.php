<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use App\Models\SchoolIdentity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    /**
     * Tampilkan form pendaftaran PPDB.
     */
    public function create()
    {
        return view('ppdb.create');
    }

    /**
     * Validasi dan simpan data pendaftaran ke database.
     * Nomor pendaftaran di-generate otomatis dengan format: PPDB-Ymd-XXXX
     */
    public function store(Request $request)
    {
        // ── Validasi ─────────────────────────────────────────────────────────
        $validated = $request->validate([
            // A. Keterangan Siswa
            'nama_siswa'           => 'required|string|max:255',
            'nik'                  => 'required|string|size:16|unique:ppdb_registrations,nik',
            'nama_panggilan'       => 'required|string|max:100',
            'jenis_kelamin'        => 'required|in:L,P',
            'tempat_lahir'         => 'required|string|max:100',
            'tanggal_lahir'        => 'required|date|before:today',
            'agama'                => 'required|string|max:50',
            'kewarganegaraan'      => 'required|string|max:50',
            'anak_ke'              => 'required|integer|min:1',
            'jml_saudara_kandung'  => 'required|integer|min:0',
            'jml_saudara_tiri'     => 'nullable|integer|min:0',
            'jml_saudara_angkat'   => 'nullable|integer|min:0',
            'bahasa_sehari_hari'   => 'required|string|max:100',
            'berat_badan'          => 'required|numeric|min:1|max:200',
            'tinggi_badan'         => 'required|numeric|min:30|max:250',
            'golongan_darah'       => 'nullable|string|max:5',
            'riwayat_penyakit'     => 'nullable|string|max:500',
            'alamat'               => 'required|string',
            'no_hp'                => 'required|string|max:20',
            'tinggal_bersama'      => 'required|string|max:100',

            // B. Orang Tua / Wali
            'nama_ayah'            => 'nullable|string|max:255',
            'tempat_lahir_ayah'    => 'nullable|string|max:100',
            'tanggal_lahir_ayah'   => 'nullable|date',
            'nama_ibu'             => 'nullable|string|max:255',
            'tempat_lahir_ibu'     => 'nullable|string|max:100',
            'tanggal_lahir_ibu'    => 'nullable|date',
            'pendidikan_ayah'      => 'nullable|string|max:100',
            'pendidikan_ibu'       => 'nullable|string|max:100',
            'pekerjaan_ayah'       => 'nullable|string|max:100',
            'pekerjaan_ibu'        => 'nullable|string|max:100',
            'nama_wali'            => 'nullable|string|max:255',
            'pendidikan_wali'      => 'nullable|string|max:100',
            'hubungan_anak_wali'   => 'nullable|string|max:100',
            'pekerjaan_wali'       => 'nullable|string|max:100',
        ], [
            'nama_siswa.required'     => 'Nama siswa wajib diisi.',
            'nik.required'            => 'NIK wajib diisi.',
            'nik.size'                => 'NIK harus 16 digit.',
            'nik.unique'              => 'NIK ini sudah didaftarkan.',
            'jenis_kelamin.required'  => 'Jenis kelamin wajib dipilih.',
            'tanggal_lahir.before'    => 'Tanggal lahir harus sebelum hari ini.',
            'berat_badan.numeric'     => 'Berat badan harus berupa angka.',
            'tinggi_badan.numeric'    => 'Tinggi badan harus berupa angka.',
        ]);

        // ── Generate Nomor Pendaftaran Otomatis ───────────────────────────────
        // Format: PPDB-Ymd-XXXX  contoh: PPDB-20260430-A4F2
        $nomorPendaftaran = 'PPDB-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Pastikan unik (retry jika collision)
        while (PpdbRegistration::where('nomor_pendaftaran', $nomorPendaftaran)->exists()) {
            $nomorPendaftaran = 'PPDB-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        }

        // ── Simpan ke Database ────────────────────────────────────────────────
        $registration = PpdbRegistration::create(array_merge($validated, [
            'nomor_pendaftaran' => $nomorPendaftaran,
            // Isi juga kolom lama agar kompatibel dengan fitur existing
            'no_pendaftaran'    => $nomorPendaftaran,
            'nama_lengkap'      => $validated['nama_siswa'],
            'alamat_jalan'      => $validated['alamat'],
            'status'            => 'pending',
        ]));

        return redirect()
            ->route('ppdb.success', $registration->id)
            ->with('nomor_pendaftaran', $nomorPendaftaran);
    }

    /**
     * Halaman konfirmasi sukses setelah pendaftaran.
     */
    public function success(int $id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        return view('ppdb.success', compact('registration'));
    }

    /**
     * Export formulir pendaftaran sebagai PDF bukti daftar.
     * Menggunakan barryvdh/laravel-dompdf.
     *
     * @param  int  $id  ID pendaftaran dari tabel ppdb_registrations
     */
    public function exportPdf(int $id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        $identity     = SchoolIdentity::first();

        $pdf = Pdf::loadView('ppdb.pdf', compact('registration', 'identity'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif',
                'dpi'                  => 96,
            ]);

        $filename = 'FormPPDB_'
            . str_replace(' ', '_', $registration->nama_terpadu)
            . '_' . ($registration->nomor_pendaftaran ?? $registration->no_pendaftaran)
            . '.pdf';

        return $pdf->download($filename);
    }
}
