<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spo2>
 */
/**
 * Factory for creating `Spo2` (oxygen saturation) model test data.
 *
 * Produces realistic oxygen saturation readings and associates each with a
 * `User`. When running against a fresh database the factory will create a
 * placeholder `User` to avoid invalid `user_id` references.
 */
class Spo2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Keep a per-process counter for debugging (no echo to avoid noisy tests)
        static $timesGenerated = 0;
        $timesGenerated++;
        Log::debug('Spo2Factory invocation', ['count' => $timesGenerated]);

        // Ensure at least one user exists so that `user_id` references are valid.
        $userCount = User::count();
        if ($userCount === 0) {
            $created = User::factory()->create();
            $userId = $created->id;
            Log::info('Spo2Factory created a placeholder User', ['user_id' => $userId]);
        } else {
            $userId = $this->faker->numberBetween(1, $userCount);
        }

        return [
            // Oxygen saturation percentage (typical resting values 90-100)
            'oxygen' => $this->faker->numberBetween(90, 100),

            // When the measurement was taken
            'time' => $this->faker->dateTimeThisYear(),

            // Associated user id
            'user_id' => $userId,
        ];
    }
}
