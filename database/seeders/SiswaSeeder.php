<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan tabel 'students' sebagai tabel utama data siswa di sistem TK Puspitasari
        // dan melakukan pemetaan field (nomor_induk -> nis, status -> aktif) agar sinkron dengan model Siswa/Student.
        $siswas = [
            [
                'nama_lengkap' => 'Bagas Prasetyo Widodo', 
                'nis' => '1482', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(2)->toDateString(), 
                'created_at' => Carbon::create(2025, 7, 15), 
                'updated_at' => Carbon::create(2025, 7, 15)
            ],
            [
                'nama_lengkap' => 'Khaira Safa Azkayra', 
                'nis' => '1493', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(4)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Fathin Adam Maulana', 
                'nis' => '1484', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(1)->toDateString(), 
                'created_at' => Carbon::create(2023, 7, 15), 
                'updated_at' => Carbon::create(2023, 7, 15)
            ],
            [
                'nama_lengkap' => 'Adam Faiz', 
                'nis' => '1489', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(4)->subMonths(9)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Muhammad Rizky Hardiyanto', 
                'nis' => '1495', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(6)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Bagas Bayu Pratama', 
                'nis' => '1490', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(6)->subMonths(3)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Humaira Adiiba Azzahra', 
                'nis' => '1491', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(4)->subMonths(8)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Javanese An Nafii', 
                'nis' => '1486', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(9)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Putri Aisyah', 
                'nis' => '1487', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(6)->subMonths(3)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Dara Nandayu Almahyra', 
                'nis' => '1468', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->subMonths(9)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Adnan Nevandra Arifin', 
                'nis' => '1496', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(5)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
            [
                'nama_lengkap' => 'Zhaira Zahwa Al Khaira', 
                'nis' => '1497', 
                'status' => 'aktif', 
                'tanggal_lahir' => Carbon::now()->subYears(4)->subMonths(9)->toDateString(), 
                'created_at' => Carbon::create(2024, 7, 15), 
                'updated_at' => Carbon::create(2024, 7, 15)
            ],
        ];

        foreach ($siswas as $siswa) {
            DB::table('students')->updateOrInsert(
                ['nis' => $siswa['nis']],
                [
                    'nama_lengkap' => $siswa['nama_lengkap'],
                    'status' => $siswa['status'],
                    'tanggal_lahir' => $siswa['tanggal_lahir'],
                    'created_at' => $siswa['created_at'],
                    'updated_at' => $siswa['updated_at']
                ]
            );
        }
    }
}
