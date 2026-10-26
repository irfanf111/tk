<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'nis'                    => $this->faker->unique()->numerify('######'),
            'nama_lengkap'           => $this->faker->name(),
            'nama_panggilan'         => $this->faker->firstName(),
            'jenis_kelamin'          => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir'           => $this->faker->city(),
            'tanggal_lahir'          => $this->faker->dateTimeBetween('-7 years', '-3 years')->format('Y-m-d'),
            'agama'                  => 'Islam',
            'kewarganegaraan'        => 'WNI',
            'anak_ke'                => $this->faker->numberBetween(1, 5),
            'jumlah_saudara_kandung' => $this->faker->numberBetween(0, 4),
            'jumlah_saudara_tiri'    => 0,
            'jumlah_saudara_angkat'  => 0,
            'bahasa_sehari_hari'     => 'Indonesia',
            'berat_badan'            => $this->faker->randomFloat(1, 12, 30),
            'tinggi_badan'           => $this->faker->randomFloat(1, 90, 130),
            'golongan_darah'         => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'riwayat_penyakit'       => null,
            'alamat'                 => $this->faker->address(),
            'no_hp'                  => $this->faker->phoneNumber(),
            'tinggal_bersama'        => 'orang_tua',
            'status'                 => 'aktif',
        ];
    }
}
