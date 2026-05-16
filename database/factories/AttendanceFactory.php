<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_pegawai' => $this->faker->name(),
            'nip'          => $this->faker->unique()->numerify('1995############'),
            'tanggal'      => date('Y-m-d'),
            'jam_masuk'    => $this->faker->time('H:i'),
            'jam_pulang'   => $this->faker->time('H:i'),
            'keterangan_kehadiran' => $this->faker->randomElement(['Hadir', 'Sakit', 'Izin', 'Dinas Luar']),
        ];
    }
}