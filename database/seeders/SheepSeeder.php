<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class SheepSeeder extends Seeder
{
    public function run(): void
    {
        $sheepData = [];

        for ($i = 0; $i < 100; $i++) {
            $sheepData[] = [
                'uid' => Str::uuid(),
                'name' => 'Domba ' . ($i + 1),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'birth_date' => Carbon::now()->subYears(rand(1, 5))->toDateString(),
                'breed' => ['Dorper', 'Garut', 'Etawa'][array_rand(['Dorper', 'Garut', 'Etawa'])],
                'weight' => rand(30, 80) + rand(0, 99) / 100, // Berat dalam kg
                'health_status' => ['Sehat', 'Sakit', 'Pemulihan', 'Karantina'][array_rand(['Sehat', 'Sakit', 'Pemulihan', 'Karantina'])],
                'pen_id' => rand(1, max: 4), // Anggap ada 10 kandang
                'last_check_date' => Carbon::now()->subDays(rand(1, 30))->toDateString(),
                'last_vaccination_date' => Carbon::now()->subDays(rand(1, 365))->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert data ke database
        DB::table('sheep')->insert($sheepData);
    }
}
