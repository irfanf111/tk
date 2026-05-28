<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolIdentity;
use App\Models\SchoolProfile;
use App\Models\VisionMission;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with school data and admin credentials.
     */
    public function run(): void
    {
        // 1. Create or update the default Admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('passwordadmin123'),
                'role' => 'admin',
            ]
        );

        // 2. Create or update the School Identity
        SchoolIdentity::updateOrCreate(
            ['npsn' => '20353717'],
            [
                'school_name' => 'TK PUSPITASARI',
                'status' => 'Swasta',
                'education_form' => 'TK',
                'ownership_status' => 'Yayasan',
                'establishment_decree' => '079.45/IO3.26/D5/1998;8Agustus 1998',
                'establishment_date' => '1998-08-08',
                'operational_decree' => '562.60/119/111/2021',
                'operational_date' => '2021-03-03',
                'address' => 'Jalan Abean RT 01 RW 05 Desa Kaliwatubumi Kecamatan Butuh Kabupaten Purworejo',
                'hamlet' => 'Abean RT 01 RW 05',
                'village' => 'Kaliwatubumi',
                'district' => 'Kec. Butuh',
                'regency' => 'Kab. Purworejo',
                'province' => 'Jawa Tengah',
                'postal_code' => '54264',
            ]
        );

        // 3. Create or update the School Profile
        SchoolProfile::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Profil TK Puspitasari',
                'content' => '<p><strong>TK PUSPITASARI</strong> merupakan salah satu sekolah jenjang TK berstatus Swasta yang berada di wilayah Kec. Butuh, Kab. Purworejo, Jawa Tengah. TK PUSPITASARI didirikan pada tanggal 8 Agustus 1998 dengan Nomor SK Pendirian 079.45/IO3.26/D5/1998;8Agustus 1998 yang berada dalam naungan Kementerian Pendidikan dan Kebudayaan. Kepala Sekolah TK PUSPITASARI saat ini adalah Kotijah,s. Pd. Operator yang bertanggung jawab adalah Sukowati.</p>' .
                             '<p>Dengan adanya keberadaan TK PUSPITASARI, diharapkan dapat memberikan kontribusi dalam mencerdaskan anak bangsa di wilayah Kec. Butuh, Kab. Purworejo.</p>' .
                             '<h3 class="text-xl font-semibold text-gray-800 mt-4 mb-2">Informasi & Tata Kelola Sekolah</h3>' .
                             '<ul>' .
                             '<li><strong>Pendiri / Yayasan:</strong> Hj. Siti Jariyah</li>' .
                             '<li><strong>Alamat Lengkap:</strong> Jalan Abean RT 01 RW 05 Desa Kaliwatubumi Kecamatan Butuh Kabupaten Purworejo</li>' .
                             '<li><strong>Jumlah Guru / Staf:</strong> 2 orang (Sumber Daya Manusia)</li>' .
                             '<li><strong>Jumlah Siswa Saat Ini:</strong> 20 siswa (Laki-laki: 12 anak, Perempuan: 8 anak)</li>' .
                             '<li><strong>Hari Operasional:</strong> Senin sampai Sabtu</li>' .
                             '<li><strong>Jam Masuk Guru:</strong> 07:00 WIB</li>' .
                             '<li><strong>Jam Masuk Siswa:</strong> 07:30 WIB</li>' .
                             '<li><strong>Jam Pulang Siswa:</strong> 10:00 WIB</li>' .
                             '<li><strong>Posisi Pengembang IT (Kerja Praktik):</strong> Muhammad Irfan Fadhila</li>' .
                             '</ul>',
            ]
        );

        // 4. Create or update the Vision & Mission
        VisionMission::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Visi & Misi',
                'content' => '<h3 class="text-xl font-bold text-gray-900 mt-4 mb-2">Visi</h3>' .
                             '<p>Mewujudkan anak didik yang Cerdas, Taqwa, dan Kreatif bersama kami di Kaliwatubumi.</p>' .
                             '<h3 class="text-xl font-bold text-gray-900 mt-6 mb-2">Misi</h3>' .
                             '<ol>' .
                             '<li>Menanamkan nilai-nilai keagamaan dan budi pekerti luhur sejak usia dini.</li>' .
                             '<li>Menyelenggarakan proses pembelajaran yang menyenangkan, kreatif, dan inovatif sesuai tahap tumbuh kembang anak.</li>' .
                             '<li>Mengembangkan potensi diri anak secara optimal untuk mempersiapkan jenjang pendidikan selanjutnya.</li>' .
                             '</ol>',
            ]
        );

        // 5. Create or update the Teachers list
        Teacher::updateOrCreate(
            ['nama' => 'Kotijah, S.Pd'],
            [
                'jabatan' => 'Kepala Sekolah & Guru',
            ]
        );

        Teacher::updateOrCreate(
            ['nama' => 'Sukowati, S. Pd.'],
            [
                'jabatan' => 'Admin Sekolah & Guru',
            ]
        );
    }
}
