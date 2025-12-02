<?php

namespace Database\Seeders;

use App\Models\Heartrate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeartrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Heartrate::factory(10)->create();
    }
}
