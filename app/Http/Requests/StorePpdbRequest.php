<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePpdbRequest extends FormRequest
{
    /**
     * Hanya user yang sudah login yang boleh mengakses form ini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Definisi rules validasi lengkap.
     *
     * Strategi:
     * - Field siswa & ortu yang wajib diisi → 'required'
     * - File dokumen → selalu opsional saat DRAFT (nullable), agar user bisa
     *   menyimpan progress bertahap. Pengecekan kelengkapan file dilakukan
     *   di PpdbController::submit() sebelum status berubah ke 'submitted'.
     * - Field wali sepenuhnya opsional.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // ── A. Identitas Siswa ────────────────────────────────────────────
            'nama_lengkap'           => ['required', 'string', 'max:255'],
            'nama_panggilan'         => ['required', 'string', 'max:100'],
            'jenis_kelamin'          => ['required', 'in:L,P'],
            'tempat_lahir'           => ['required', 'string', 'max:100'],
            'tanggal_lahir'          => ['required', 'date', 'before:today'],
            'agama'                  => ['required', 'string', 'max:50'],
            'kewarganegaraan'        => ['required', 'in:WNI,WNA'],
            'anak_ke'                => ['required', 'integer', 'min:1'],
            'jumlah_saudara_kandung' => ['required', 'integer', 'min:0'],
            'jumlah_saudara_tiri'    => ['nullable', 'integer', 'min:0'],
            'jumlah_saudara_angkat'  => ['nullable', 'integer', 'min:0'],
            'bahasa_sehari_hari'     => ['required', 'string', 'max:100'],
            'berat_badan'            => ['required', 'numeric', 'min:1', 'max:200'],
            'tinggi_badan'           => ['required', 'numeric', 'min:30', 'max:250'],
            'golongan_darah'         => ['nullable', 'string', 'max:5'],
            'riwayat_penyakit'       => ['nullable', 'string', 'max:1000'],
            'alamat'                 => ['required', 'string', 'max:500'],
            'no_hp'                  => ['required', 'string', 'max:20'],
            'tinggal_bersama'        => ['required', 'in:orang_tua,menumpang,asrama,kontrak'],

            // ── B. Data Ayah ──────────────────────────────────────────────────
            'nama_ayah'              => ['required', 'string', 'max:255'],
            'tempat_lahir_ayah'      => ['required', 'string', 'max:100'],
            'tanggal_lahir_ayah'     => ['required', 'date'],
            'pendidikan_ayah'        => ['required', 'string', 'max:100'],
            'pekerjaan_ayah'         => ['required', 'string', 'max:100'],

            // ── C. Data Ibu ───────────────────────────────────────────────────
            'nama_ibu'               => ['required', 'string', 'max:255'],
            'tempat_lahir_ibu'       => ['required', 'string', 'max:100'],
            'tanggal_lahir_ibu'      => ['required', 'date'],
            'pendidikan_ibu'         => ['required', 'string', 'max:100'],
            'pekerjaan_ibu'          => ['required', 'string', 'max:100'],

            // ── D. Data Wali (Opsional) ───────────────────────────────────────
            // Semua field wali nullable — hanya diisi jika bukan tinggal dg orang tua
            'nama_wali'              => ['nullable', 'string', 'max:255'],
            'pendidikan_wali'        => ['nullable', 'string', 'max:100'],
            'hubungan_wali'          => ['nullable', 'string', 'max:100'],
            'pekerjaan_wali'         => ['nullable', 'string', 'max:100'],

            // ── E. Dokumen Upload (Selalu opsional saat DRAFT) ────────────────
            // Pengecekan wajib ada dilakukan saat SUBMIT di controller.
            'akta_kelahiran'         => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'kartu_keluarga'         => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'ijazah_tk'              => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Siswa
            'nama_lengkap.required'           => 'Nama lengkap siswa wajib diisi.',
            'nama_panggilan.required'          => 'Nama panggilan wajib diisi.',
            'jenis_kelamin.required'           => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'                 => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'tempat_lahir.required'            => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'           => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before'             => 'Tanggal lahir harus sebelum hari ini.',
            'agama.required'                   => 'Agama wajib diisi.',
            'kewarganegaraan.required'         => 'Kewarganegaraan wajib dipilih.',
            'kewarganegaraan.in'               => 'Kewarganegaraan harus WNI atau WNA.',
            'anak_ke.required'                 => 'Urutan anak wajib diisi.',
            'anak_ke.min'                      => 'Urutan anak minimal 1.',
            'jumlah_saudara_kandung.required'  => 'Jumlah saudara kandung wajib diisi.',
            'jumlah_saudara_kandung.min'       => 'Jumlah saudara tidak boleh negatif.',
            'bahasa_sehari_hari.required'      => 'Bahasa sehari-hari wajib diisi.',
            'berat_badan.required'             => 'Berat badan wajib diisi.',
            'berat_badan.numeric'              => 'Berat badan harus berupa angka.',
            'tinggi_badan.required'            => 'Tinggi badan wajib diisi.',
            'tinggi_badan.numeric'             => 'Tinggi badan harus berupa angka.',
            'alamat.required'                  => 'Alamat wajib diisi.',
            'no_hp.required'                   => 'Nomor HP wajib diisi.',
            'tinggal_bersama.required'         => 'Status tinggal wajib dipilih.',
            'tinggal_bersama.in'               => 'Pilihan tinggal tidak valid.',

            // Ayah
            'nama_ayah.required'               => 'Nama ayah wajib diisi.',
            'tempat_lahir_ayah.required'       => 'Tempat lahir ayah wajib diisi.',
            'tanggal_lahir_ayah.required'      => 'Tanggal lahir ayah wajib diisi.',
            'pendidikan_ayah.required'         => 'Pendidikan terakhir ayah wajib diisi.',
            'pekerjaan_ayah.required'          => 'Pekerjaan ayah wajib diisi.',

            // Ibu
            'nama_ibu.required'                => 'Nama ibu wajib diisi.',
            'tempat_lahir_ibu.required'        => 'Tempat lahir ibu wajib diisi.',
            'tanggal_lahir_ibu.required'       => 'Tanggal lahir ibu wajib diisi.',
            'pendidikan_ibu.required'          => 'Pendidikan terakhir ibu wajib diisi.',
            'pekerjaan_ibu.required'           => 'Pekerjaan ibu wajib diisi.',

            // Dokumen
            'akta_kelahiran.mimes'             => 'Akta kelahiran harus berformat PDF, JPG, atau PNG.',
            'akta_kelahiran.max'               => 'Ukuran file akta kelahiran maksimal 2 MB.',
            'kartu_keluarga.mimes'             => 'Kartu keluarga harus berformat PDF, JPG, atau PNG.',
            'kartu_keluarga.max'               => 'Ukuran file kartu keluarga maksimal 2 MB.',
            'ijazah_tk.mimes'                  => 'File ijazah TK harus berformat PDF, JPG, atau PNG.',
            'ijazah_tk.max'                    => 'Ukuran file ijazah TK maksimal 2 MB.',
        ];
    }

    /**
     * Nama atribut yang lebih ramah untuk pesan error default Laravel.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_lengkap'           => 'nama lengkap',
            'nama_panggilan'         => 'nama panggilan',
            'jenis_kelamin'          => 'jenis kelamin',
            'tanggal_lahir'          => 'tanggal lahir',
            'anak_ke'                => 'urutan anak',
            'jumlah_saudara_kandung' => 'jumlah saudara kandung',
            'jumlah_saudara_tiri'    => 'jumlah saudara tiri',
            'jumlah_saudara_angkat'  => 'jumlah saudara angkat',
            'bahasa_sehari_hari'     => 'bahasa sehari-hari',
            'berat_badan'            => 'berat badan',
            'tinggi_badan'           => 'tinggi badan',
            'tinggal_bersama'        => 'status tinggal',
            'no_hp'                  => 'nomor HP',
            'tanggal_lahir_ayah'     => 'tanggal lahir ayah',
            'tanggal_lahir_ibu'      => 'tanggal lahir ibu',
            'akta_kelahiran'         => 'akta kelahiran',
            'kartu_keluarga'         => 'kartu keluarga',
            'ijazah_tk'              => 'ijazah TK',
        ];
    }
}
