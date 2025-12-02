<?php

namespace Database\Seeders;

use App\Models\Spo2;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Spo2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spo2::factory(10)->create();
    }
}
