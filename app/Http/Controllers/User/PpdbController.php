<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePpdbRequest;
use App\Models\Document;
use App\Models\Registration;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PpdbController extends Controller
{
    /**
     * Status yang dianggap sudah "dikunci" — tidak boleh diedit oleh user.
     * Hanya 'draft' dan 'rejected' yang masih bisa diubah.
     */
    private const LOCKED_STATUSES = [
        Registration::STATUS_SUBMITTED,
        Registration::STATUS_VERIFIED,
        Registration::STATUS_ACCEPTED,
        Registration::STATUS_NOT_ACCEPTED,
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX — Dashboard user: tampilkan status pendaftaran saat ini
    // ─────────────────────────────────────────────────────────────────────────

    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Eager load relasi berantai: student → registration, document, studentParent
        $student = $user->student()->with(['registration', 'document', 'studentParent'])->first();

        $registration = $student?->registration;

        return view('ppdb.user.index', compact('student', 'registration'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE — Tampilkan form pendaftaran kosong atau terisi (autofill draft)
    // ─────────────────────────────────────────────────────────────────────────

    public function create(): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Cek apakah user sudah punya data sebelumnya
        $student = $user->student()->with(['registration', 'document', 'studentParent'])->first();

        // Jika sudah ada, cek apakah statusnya masih bisa diedit
        if ($student && $student->registration) {
            if (in_array($student->registration->status, self::LOCKED_STATUSES)) {
                return redirect()
                    ->route('ppdb.user.index')
                    ->with('error', 'Pendaftaran Anda sudah dikirim dan tidak dapat diubah lagi. Hubungi sekolah jika ada kesalahan data.');
            }
        }

        // Passing data lama ke view untuk autofill (null jika belum ada)
        return view('ppdb.user.create', [
            'student' => $student,
            'studentParent' => $student?->studentParent,
            'document' => $student?->document,
            'registration' => $student?->registration,
        ]);
    }

    /**
     * Alias edit() → sama persis dengan create() karena form-nya satu.
     */
    public function edit(): View|RedirectResponse
    {
        return $this->create();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STORE — Simpan/Update data sebagai DRAFT (transaksi multi-tabel)
    // ─────────────────────────────────────────────────────────────────────────

    public function store(StorePpdbRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Ambil student yang sudah ada (jika ada)
        $student = $user->student;
        $registration = $student?->registration;

        // Tolak jika status sudah dikunci (defense-in-depth, form sudah di-guard di create())
        if ($registration && in_array($registration->status, self::LOCKED_STATUSES)) {
            return redirect()
                ->route('ppdb.user.index')
                ->with('error', 'Pendaftaran Anda sudah dikunci dan tidak dapat diubah.');
        }

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // ── 1. Simpan / Update tabel `students` ───────────────────────────
            $studentData = [
                'user_id' => $user->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nama_panggilan' => $validated['nama_panggilan'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'agama' => $validated['agama'],
                'kewarganegaraan' => $validated['kewarganegaraan'],
                'anak_ke' => $validated['anak_ke'],
                'jumlah_saudara_kandung' => $validated['jumlah_saudara_kandung'],
                'jumlah_saudara_tiri' => $validated['jumlah_saudara_tiri'] ?? 0,
                'jumlah_saudara_angkat' => $validated['jumlah_saudara_angkat'] ?? 0,
                'bahasa_sehari_hari' => $validated['bahasa_sehari_hari'],
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'golongan_darah' => $validated['golongan_darah'] ?? null,
                'riwayat_penyakit' => $validated['riwayat_penyakit'] ?? null,
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'tinggal_bersama' => $validated['tinggal_bersama'],
            ];

            // updateOrCreate: jika student belum ada → buat baru, jika ada → update
            $student = Student::updateOrCreate(
                ['user_id' => $user->id],
                $studentData
            );

            // ── 2. Simpan / Update tabel `student_parents` ────────────────────
            $parentData = [
                'nama_ayah' => $validated['nama_ayah'],
                'tempat_lahir_ayah' => $validated['tempat_lahir_ayah'],
                'tanggal_lahir_ayah' => $validated['tanggal_lahir_ayah'],
                'pendidikan_ayah' => $validated['pendidikan_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'tempat_lahir_ibu' => $validated['tempat_lahir_ibu'],
                'tanggal_lahir_ibu' => $validated['tanggal_lahir_ibu'],
                'pendidikan_ibu' => $validated['pendidikan_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                // Wali — opsional, simpan null jika tidak diisi
                'nama_wali' => $validated['nama_wali'] ?? null,
                'pendidikan_wali' => $validated['pendidikan_wali'] ?? null,
                'hubungan_wali' => $validated['hubungan_wali'] ?? null,
                'pekerjaan_wali' => $validated['pekerjaan_wali'] ?? null,
            ];

            // updateOrCreate berdasarkan student_id
            StudentParent::updateOrCreate(
                ['student_id' => $student->id],
                $parentData
            );

            // ── 3. Handle Upload Dokumen → tabel `documents` ──────────────────
            // Ambil dokumen yang sudah ada (jika ada) untuk menjaga path lama
            $existingDoc = Document::firstOrNew(['student_id' => $student->id]);
            $existingDoc->student_id = $student->id;

            // Helper closure: upload file hanya jika ada file baru di request,
            // hapus file lama dari storage terlebih dahulu untuk menghemat ruang.
            $uploadFile = function (string $field, string $storagePath) use ($request, $existingDoc): void {
                if ($request->hasFile($field) && $request->file($field)->isValid()) {
                    // Hapus file lama jika ada
                    if ($existingDoc->{$field} && Storage::disk('public')->exists($existingDoc->{$field})) {
                        Storage::disk('public')->delete($existingDoc->{$field});
                    }
                    // Simpan file baru dan perbarui path di model
                    $existingDoc->{$field} = $request->file($field)->store($storagePath, 'public');
                }
            };

            $uploadFile('akta_kelahiran', 'ppdb/akta');
            $uploadFile('kartu_keluarga', 'ppdb/kk');
            $uploadFile('ijazah_tk', 'ppdb/ijazah');

            $existingDoc->save();

            // ── 4. Buat / Pertahankan status DRAFT di tabel `registrations` ───
            // Jika sudah ada registration, jangan ubah status (bisa jadi 'rejected').
            // Jika belum ada, buat baru dengan status 'draft'.
            Registration::firstOrCreate(
                ['student_id' => $student->id],
                ['status' => Registration::STATUS_DRAFT]
            );

            DB::commit();

            return redirect()
                ->route('ppdb.user.index')
                ->with('success', 'Data pendaftaran berhasil disimpan sebagai draft. Anda bisa melanjutkan pengisian kapan saja.');

        } catch (\Throwable $e) {
            DB::rollBack();

            // 🔥 INI BAGIAN YANG SAYA BONGKAR BIAR KELUAR ASLINYA 🔥
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'ERROR DATABASE ASLI: ' . $e->getMessage() . ' | Baris: ' . $e->getLine());
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SUBMIT — Finalisasi: ubah status 'draft'/'rejected' → 'submitted'
    // ─────────────────────────────────────────────────────────────────────────

    public function submit(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $student = $user->student()->with(['registration', 'document'])->first();

        // ── Validasi keberadaan data ──────────────────────────────────────────
        if (!$student || !$student->registration) {
            return redirect()
                ->route('ppdb.user.index')
                ->with('error', 'Anda belum memiliki data pendaftaran. Silakan isi formulir terlebih dahulu.');
        }

        $registration = $student->registration;

        // ── Pastikan status masih bisa disubmit ──────────────────────────────
        if (in_array($registration->status, self::LOCKED_STATUSES)) {
            return redirect()
                ->route('ppdb.user.index')
                ->with('error', 'Pendaftaran Anda sudah dalam status "' . $registration->status_label . '" dan tidak dapat dikirim ulang.');
        }

        // ── Validasi kelengkapan dokumen WAJIB ───────────────────────────────
        // Akta kelahiran dan KK wajib ada sebelum submit. Ijazah TK opsional.
        $document = $student->document;
        $missingDocs = [];

        if (!$document || !$document->akta_kelahiran) {
            $missingDocs[] = 'Akta Kelahiran';
        }
        if (!$document || !$document->kartu_keluarga) {
            $missingDocs[] = 'Kartu Keluarga (KK)';
        }

        if (!empty($missingDocs)) {
            return redirect()
                ->route('ppdb.user.edit')
                ->with('error', 'Dokumen berikut wajib diupload sebelum mengirim pendaftaran: ' . implode(', ', $missingDocs) . '.');
        }

        // ── Semua validasi lolos → ubah status ke 'submitted' ─────────────────
        DB::beginTransaction();

        try {
            $registration->update([
                'status' => Registration::STATUS_SUBMITTED,
                'notes' => null, // reset catatan admin sebelumnya (jika re-submit)
            ]);

            DB::commit();

            return redirect()
                ->route('ppdb.user.index')
                ->with('success', 'Pendaftaran Anda telah berhasil dikirim! Kami akan segera memverifikasi data Anda. Pantau status di halaman ini.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('ppdb.user.index')
                ->with('error', 'ERROR SUBMIT: ' . $e->getMessage());
        }
    }
}