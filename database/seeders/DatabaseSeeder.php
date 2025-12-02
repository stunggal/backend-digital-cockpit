<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DokterSeeder::class);
        $this->call(PasienSeeder::class);
        $this->call(JadwalSeeder::class);
        $this->call(HeartrateSeeder::class);
        $this->call(BloodpressureSeeder::class);
        $this->call(Spo2Seeder::class);
    }
}
