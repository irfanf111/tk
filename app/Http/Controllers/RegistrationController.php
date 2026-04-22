<?php

namespace App\Http\Controllers;

use App\Models\PpdbRegistration;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:20|unique:ppdb_registrations,nik',
            'alamat_jalan' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $registration = PpdbRegistration::create([
                'no_pendaftaran' => 'PPDB-' . date('Y') . '-' . strtoupper(Str::random(5)),
                'nama_lengkap' => $validated['nama_lengkap'],
                'nama_panggilan' => $validated['nama_panggilan'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nik' => $validated['nik'],
                'alamat_jalan' => $validated['alamat_jalan'],
                'status' => 'pending',
            ]);

            StudentParent::create([
                'ppdb_registration_id' => $registration->id,
                'nama_ayah' => $validated['nama_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'no_hp_ortu' => $validated['no_hp_ortu'],
            ]);
        });

        return redirect()->back()->with('success', 'Your registration has been submitted successfully. We will contact you soon.');
    }
}
