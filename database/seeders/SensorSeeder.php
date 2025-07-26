<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('sensor')->insert([
                'tanggal' => Carbon::now()->subDays($i),
                'suhu' => rand(250, 320) / 10, // 25.0 - 32.0 °C
                'kelembapan' => rand(700, 950) / 10, // 70% - 95%
                'ketinggian_air' => rand(50, 200) / 10, // 5.0 - 20.0 cm
            ]);
        }
    }
}
