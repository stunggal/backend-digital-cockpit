<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
/**
 * Factory for creating `Dokter` (doctor) model test data.
 *
 * This factory produces realistic-looking doctor records with a linked
 * `User` via `User::factory()`. It uses Faker to populate names,
 * contact details, and specialties. Logging replaces noisy echo output
 * so automated test runs stay cleaner.
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Use logging (info) instead of echo to avoid polluting test output
        Log::info('Seeding Dokter at factory');

        // Return an associative array matching the Dokter model attributes.
        // Each key should align with the model's fillable/column names.
        return [
            // Full display name prefixed with 'Dr.'
            'nama' => 'Dr. ' . $this->faker->firstName() . ' ' . $this->faker->lastName(),

            // Postal address string (multi-line from Faker)
            'alamat' => $this->faker->address(),

            // Phone number in a realistic (but fake) format
            'no_telp' => $this->faker->phoneNumber(),

            // National identity-like number (using credit card format as placeholder)
            'no_ktp' => $this->faker->creditCardNumber(),

            // Gender: 'L' = Laki-laki (male), 'P' = Perempuan (female)
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),

            // Date of birth
            'tanggal_lahir' => $this->faker->date(),

            // Medical specialty (chosen from a small list)
            'spesialis' => $this->faker->randomElement(['Umum', 'Gigi', 'Kandungan', 'Anak', 'Bedah']),

            // Active status string
            'status' => $this->faker->randomElement(['Aktif', 'Tidak Aktif']),

            // Avatar URL: using picsum for placeholder images; commented alternative
            // 'avatar' => 'https://via.placeholder.com/640x640.png/' .  $this->faker->hexColor() . '?text=' . $this->faker->word(),
            'avatar' => 'https://picsum.photos/id/' . $this->faker->numberBetween(1, 1000) . '/640/640',

            // Associate this Dokter with a User. This will create a User if none exist.
            'user_id' => User::factory(),
        ];
    }
}
