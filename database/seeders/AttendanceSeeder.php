<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat minimal 15 data awal sesuai instruksi
        Attendance::factory()->count(15)->create();
    }
}