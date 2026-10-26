<?php

namespace Database\Factories;

use App\Models\LpadStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LpadStudent>
 */
class LpadStudentFactory extends Factory
{
    protected $model = LpadStudent::class;

    public function definition(): array
    {
        return [
            'no_induk'      => $this->faker->unique()->numerify('########'),
            'nama_lengkap'  => $this->faker->name(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-7 years', '-3 years')->format('Y-m-d'),
            'student_id'    => null,
        ];
    }
}
