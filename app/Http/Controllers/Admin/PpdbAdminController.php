<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpdbAdminController extends Controller
{
    /**
     * Status yang valid — dipakai untuk filter & validasi di semua method.
     */
    private const VALID_STATUSES = [
        Registration::STATUS_DRAFT,
        Registration::STATUS_SUBMITTED,
        Registration::STATUS_VERIFIED,
        Registration::STATUS_REJECTED,
        Registration::STATUS_ACCEPTED,
        Registration::STATUS_NOT_ACCEPTED,
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX — Daftar semua pendaftar dengan filter status & pagination
    // ─────────────────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        // Validasi param filter agar tidak ada SQL injection / nilai tidak valid
        $filterStatus = in_array($request->query('status'), self::VALID_STATUSES)
            ? $request->query('status')
            : null;

        // Eager load: Registration → Student (hanya kolom yang dibutuhkan di index)
        // Urutkan dari submitted terbaru ke atas, lalu paginate 15
        $query = Registration::with(['student:id,nama_lengkap,nama_panggilan,no_hp', 'verifier:id,name'])
            ->latest('updated_at');

        // Terapkan filter status jika ada
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        } else {
            // Default: sembunyikan draft (belum dikirim) dari pandangan admin
            // Hapus baris ini jika admin perlu melihat draft juga.
            $query->where('status', '!=', Registration::STATUS_DRAFT);
        }

        $registrations = $query->paginate(15)->withQueryString();

        // Hitung ringkasan per status untuk ditampilkan sebagai badge counter
        $summary = Registration::selectRaw('status, count(*) as total')
            ->whereIn('status', [
                Registration::STATUS_SUBMITTED,
                Registration::STATUS_VERIFIED,
                Registration::STATUS_REJECTED,
                Registration::STATUS_ACCEPTED,
                Registration::STATUS_NOT_ACCEPTED,
            ])
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.ppdb.index', compact('registrations', 'filterStatus', 'summary'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SHOW — Detail lengkap satu pendaftar (siswa + ortu + dokumen)
    // ─────────────────────────────────────────────────────────────────────────

    public function show(int $id): View
    {
        // Eager load berantai: Registration → Student → StudentParent, Document
        // Ini memastikan 0 N+1 query untuk halaman detail
        $registration = Registration::with([
            'student.studentParent',
            'student.document',
            'verifier:id,name',
        ])->findOrFail($id);

        $student = $registration->student;
        $parent  = $student?->studentParent;
        $doc     = $student?->document;

        return view('admin.ppdb.show', compact('registration', 'student', 'parent', 'doc'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // VERIFY — Ubah status: submitted → verified | rejected
    // ─────────────────────────────────────────────────────────────────────────

    public function verify(Request $request, int $id): RedirectResponse
    {
        $registration = Registration::findOrFail($id);

        // Hanya boleh diverifikasi jika masih berstatus 'submitted'
        if ($registration->status !== Registration::STATUS_SUBMITTED) {
            return redirect()
                ->route('admin.ppdb.show', $id)
                ->with('error', 'Hanya pendaftaran berstatus "Menunggu Verifikasi" yang dapat diverifikasi.');
        }

        $request->validate([
            'action' => ['required', 'in:verified,rejected'],
            // Catatan wajib diisi hanya jika aksi adalah 'rejected'
            'notes'  => ['required_if:action,rejected', 'nullable', 'string', 'max:1000'],
        ], [
            'action.required'      => 'Aksi verifikasi wajib dipilih.',
            'action.in'            => 'Aksi tidak valid.',
            'notes.required_if'    => 'Catatan revisi wajib diisi saat menolak pendaftaran.',
        ]);

        $newStatus = $request->input('action'); // 'verified' atau 'rejected'

        $registration->update([
            'status'      => $newStatus,
            'notes'       => $newStatus === Registration::STATUS_REJECTED
                ? $request->input('notes')
                : null,          // Hapus catatan lama jika di-approve
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $label = $newStatus === Registration::STATUS_VERIFIED ? 'diverifikasi' : 'dikembalikan dengan catatan revisi';

        return redirect()
            ->route('admin.ppdb.show', $id)
            ->with('success', "Pendaftaran atas nama \"{$registration->student?->nama_lengkap}\" berhasil {$label}.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DECIDE — Ubah status: verified → accepted | not_accepted
    // ─────────────────────────────────────────────────────────────────────────

    public function decide(Request $request, int $id): RedirectResponse
    {
        $registration = Registration::with('student:id,nama_lengkap')->findOrFail($id);

        // Syarat ketat: HANYA bisa diputuskan jika status sudah 'verified'
        if ($registration->status !== Registration::STATUS_VERIFIED) {
            return redirect()
                ->route('admin.ppdb.show', $id)
                ->with('error', 'Keputusan penerimaan hanya dapat diberikan pada pendaftaran yang sudah berstatus "Terverifikasi".');
        }

        $request->validate([
            'decision' => ['required', 'in:accepted,not_accepted'],
            'notes'    => ['nullable', 'string', 'max:1000'],
        ], [
            'decision.required' => 'Keputusan penerimaan wajib dipilih.',
            'decision.in'       => 'Nilai keputusan tidak valid.',
        ]);

        $decision = $request->input('decision');

        $registration->update([
            'status'      => $decision,
            'notes'       => $request->input('notes'),
            'verified_by' => auth()->id(),  // Catat siapa yang membuat keputusan akhir
            'verified_at' => now(),
        ]);

        $label = $decision === Registration::STATUS_ACCEPTED ? 'DITERIMA' : 'TIDAK DITERIMA';

        return redirect()
            ->route('admin.ppdb.show', $id)
            ->with('success', "Pendaftaran atas nama \"{$registration->student?->nama_lengkap}\" telah diputuskan: {$label}.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CETAK — Print preview rekap data pendaftaran (sistem baru)
    // Menerima ID dari tabel `registrations` (dikirim oleh Filament Resource baru)
    // ─────────────────────────────────────────────────────────────────────────

    public function cetak(int $id): View
    {
        $registration = Registration::with([
            'student.user:id,name,email',
            'student.studentParent',
            'student.document',
            'verifier:id,name',
        ])->findOrFail($id);

        $student = $registration->student;
        $parent  = $student?->studentParent;
        $doc     = $student?->document;
        $user    = $student?->user;

        return view('admin.ppdb.cetak', compact(
            'registration', 'student', 'parent', 'doc', 'user'
        ));
    }

    /**
     * Export rekap data pendaftaran PPDB sebagai A4 PDF.
     */
    public function exportPdf(int $id)
    {
        $registration = Registration::with([
            'student.user:id,name,email',
            'student.studentParent',
            'student.document',
            'verifier:id,name',
        ])->findOrFail($id);

        $student = $registration->student;
        $parent  = $student?->studentParent;
        $doc     = $student?->document;
        $user    = $student?->user;
        $identity = \App\Models\SchoolIdentity::first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.ppdb.pdf', compact(
            'registration', 'student', 'parent', 'doc', 'user', 'identity'
        ))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif',
                'dpi'                  => 96,
                'chroot'               => base_path(),
            ]);

        $filename = 'RekapPPDB_'
            . str_replace(' ', '_', $student->nama_lengkap)
            . '_' . ($registration->no_pendaftaran ?? $registration->id)
            . '.pdf';

        return $pdf->download($filename);
    }
}
