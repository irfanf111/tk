<?php

namespace App\Livewire;

use App\Models\PpdbRegistration;
use App\Models\StudentParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class RegistrationForm extends Component
{
    // Student fields
    public string $nama_lengkap = '';
    public string $nama_panggilan = '';
    public string $jenis_kelamin = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $nik = '';
    public string $alamat_jalan = '';

    // Parent fields
    public string $nama_ayah = '';
    public string $nama_ibu = '';
    public string $no_hp_ortu = '';

    // UI state
    public string $successMessage = '';

    protected function rules(): array
    {
        return [
            'nama_lengkap'  => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik'           => 'required|string|max:20|unique:ppdb_registrations,nik',
            'alamat_jalan'  => 'required|string',
            'nama_ayah'     => 'required|string|max:255',
            'nama_ibu'      => 'required|string|max:255',
            'no_hp_ortu'    => 'required|string|max:20',
        ];
    }

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
        'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
        'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
        'nik.required' => 'NIK wajib diisi.',
        'nik.unique' => 'NIK sudah terdaftar. Silakan gunakan NIK yang berbeda.',
        'nik.max' => 'NIK maksimal 20 karakter.',
        'alamat_jalan.required' => 'Alamat wajib diisi.',
        'nama_ayah.required' => 'Nama ayah wajib diisi.',
        'nama_ibu.required' => 'Nama ibu wajib diisi.',
        'no_hp_ortu.required' => 'Nomor HP/WhatsApp wajib diisi.',
        'no_hp_ortu.max' => 'Nomor HP maksimal 20 karakter.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->successMessage = '';

        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $registration = PpdbRegistration::create([
                'no_pendaftaran' => 'PPDB-' . date('Y') . '-' . strtoupper(Str::random(5)),
                'nama_lengkap'  => $validated['nama_lengkap'],
                'nama_panggilan' => $validated['nama_panggilan'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir'  => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nik'           => $validated['nik'],
                'alamat_jalan'  => $validated['alamat_jalan'],
                'status'        => 'pending',
            ]);

            StudentParent::create([
                'ppdb_registration_id' => $registration->id,
                'nama_ayah'  => $validated['nama_ayah'],
                'nama_ibu'   => $validated['nama_ibu'],
                'no_hp_ortu' => $validated['no_hp_ortu'],
            ]);
        });

        $this->reset([
            'nama_lengkap', 'nama_panggilan', 'jenis_kelamin',
            'tempat_lahir', 'tanggal_lahir', 'nik', 'alamat_jalan',
            'nama_ayah', 'nama_ibu', 'no_hp_ortu',
        ]);

        $this->successMessage = 'Pendaftaran Berhasil! Silakan tunggu informasi selanjutnya dari panitia.';
    }

    public function render()
    {
        return view('livewire.registration-form')
            ->layout('components.layouts.registration');
    }
}
