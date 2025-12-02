<?php

namespace Database\Seeders;

use App\Models\Bloodpressure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodpressureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bloodpressure::factory(10)->create();
    }
}
