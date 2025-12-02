<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
/**
 * Factory for creating `Jadwal` (scheduling) model test data.
 *
 * Produces appointment-like entries with a linked doctor (`dokter_id`) and
 * patient (`pasien_id`). The factory uses Faker to choose events, dates,
 * and times. Values such as `dokter_id`/`pasien_id` are chosen from small
 * ranges by default to keep seed datasets compact; adjust as needed.
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // A small list of possible appointment/event descriptions to pick from.
        $events = [
            'Check-up Rutin',
            'Pemeriksaan Kesehatan',
            'Pergantian Infus',
            'Operasi Minor',
            'Operasi Mayor',
            'Pemeriksaan Laboratorium',
            'Pemeriksaan Radiologi',
            'Pemeriksaan Jantung',
            'Pemeriksaan Mata',
            'Fisioterapi',
            'Kontrol Pasca Operasi',
            'Pemeriksaan Gigi',
            'Pemeriksaan Kandungan',
            'Pemeriksaan Anak',
            'Pemeriksaan Bedah',
        ];

        // Logging for debugging factory generation during local seeding.
        Log::debug('JadwalFactory generating a jadwal record');

        // NOTE: The default ranges for `dokter_id` and `pasien_id` (1-3, 1-10)
        // assume your seed dataset contains at least that many records. If you
        // run this factory on a fresh database, consider creating related
        // Dokter/Pasien records first or change these to use `Model::factory()`
        // to automatically create related models.

        return [
            // Foreign key to Dokter (doctor). Consider replacing with
            // `Dokter::factory()` if you want the factory to create the related model.
            'dokter_id' => $this->faker->numberBetween(1, 3),

            // Foreign key to Pasien (patient)
            'pasien_id' => $this->faker->numberBetween(1, 10),

            // The event/appointment description
            'event' => $this->faker->randomElement($events),

            // Date in Y-m-d format, within a short window around today
            'tanggal' => $this->faker->dateTimeBetween('-3 days', '+3 days')->format('Y-m-d'),

            // Hour of the appointment, normalized to the top of the hour
            'jam' => $this->faker->time('H:00'),

            // Status of the appointment
            'status' => $this->faker->randomElement(['Menunggu', 'Diperiksa', 'Selesai']),

            // Optional/long-form notes
            'catatan' => $this->faker->realText(),
        ];
    }
}
