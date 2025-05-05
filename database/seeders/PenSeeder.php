<?php

namespace Database\Seeders;

use App\Models\Pen;
use Illuminate\Database\Seeder;

class PenSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $pens = [
      [
        'name' => 'Kandang Utama',
        'location' => 'Blok A',
        'capacity' => 20,
        'description' => 'Kandang utama untuk domba jantan dewasa'
      ],
      [
        'name' => 'Kandang B',
        'location' => 'Blok B',
        'capacity' => 15,
        'description' => 'Kandang untuk domba betina dewasa'
      ],
      [
        'name' => 'Kandang C',
        'location' => 'Blok C',
        'capacity' => 10,
        'description' => 'Kandang untuk domba anakan'
      ],
      [
        'name' => 'Kandang Karantina',
        'location' => 'Blok D',
        'capacity' => 5,
        'description' => 'Kandang isolasi untuk domba sakit'
      ],
    ];

    foreach ($pens as $pen) {
      Pen::create($pen);
    }
  }
}