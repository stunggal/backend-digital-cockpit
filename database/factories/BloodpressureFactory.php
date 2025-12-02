<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bloodpressure>
 */
/**
 * Factory for creating Bloodpressure model test data.
 *
 * This factory returns realistic systolic/diastolic values and ties
 * each generated reading to an existing `User`. If no users exist
 * in the database the factory will create one to avoid invalid
 * `user_id` values when seeding/testing in an empty database.
 */
class BloodpressureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Track how many times this factory has been invoked during the current PHP process.
        // Kept as a static so repeated calls increment the same counter. We don't echo
        // here to avoid noisy output during automated tests; use logs if needed.
        static $timesGenerated = 0;
        $timesGenerated++;

        // Ensure there is at least one user in the database. When running tests or
        // seeding on a fresh database there may be zero users which would make the
        // `numberBetween(1, $users)` call invalid (min > max). Create a user if needed.
        $userCount = User::count();
        if ($userCount === 0) {
            // Create a user using its factory and use its id. This keeps the BP record
            // relationships valid when seeding an empty DB.
            $created = User::factory()->create();
            $userId = $created->id;
            // Log creation for debugging; this is safe in most environments.
            Log::info('BloodpressureFactory created a placeholder User', ['user_id' => $userId]);
        } else {
            // Pick an existing user id at random from the available range.
            $userId = $this->faker->numberBetween(1, $userCount);
        }

        // Return realistic-looking blood pressure data.
        return [
            // Systolic pressure in mmHg (typical resting range 90-140)
            'systolic' => $this->faker->numberBetween(90, 140),
            // Diastolic pressure in mmHg (typical resting range 60-90)
            'diastolic' => $this->faker->numberBetween(60, 90),
            // Timestamp when the reading was taken (within this year)
            'time' => $this->faker->dateTimeThisYear(),
            // Associated user who owns this reading
            'user_id' => $userId,
        ];
    }
}
