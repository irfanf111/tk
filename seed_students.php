<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;

$students = [
    ['nama_lengkap' => 'Aghnia Annindya Putri', 'jenis_kelamin' => 'P'],
    ['nama_lengkap' => 'Almayra Khanza Danindra', 'jenis_kelamin' => 'P'],
    ['nama_lengkap' => 'Arkana Putra Mulyadi', 'jenis_kelamin' => 'L'],
    ['nama_lengkap' => 'Claudia Rahma Latifah', 'jenis_kelamin' => 'P'],
    ['nama_lengkap' => 'Hannan Habibillah', 'jenis_kelamin' => 'L'],
    ['nama_lengkap' => 'Muhammad Lukman Hafiz', 'jenis_kelamin' => 'L'],
    ['nama_lengkap' => 'Nadira Aprilia Ramadani', 'jenis_kelamin' => 'P'],
    ['nama_lengkap' => 'Thara Yurfina Artanti', 'jenis_kelamin' => 'P'],
    ['nama_lengkap' => 'Zhafran Syariq Phuhairi', 'jenis_kelamin' => 'L'],
];

foreach ($students as $student) {
    Student::updateOrCreate(
        ['nama_lengkap' => $student['nama_lengkap']],
        [
            'status' => 'aktif',
            'jenis_kelamin' => $student['jenis_kelamin'],
            'kewarganegaraan' => 'WNI'
        ]
    );
}

echo "Berhasil menambahkan " . count($students) . " siswa baru!\n";
