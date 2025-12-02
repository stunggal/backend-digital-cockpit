<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Heartrate>
 */
/**
 * Factory for creating `Heartrate` model test data.
 *
 * Produces plausible heart rate readings (beats per minute) and
 * associates each reading with a `User`. If there are no users in the
 * database this factory will create one to ensure `user_id` is valid
 * when seeding an empty database.
 */
class HeartrateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Keep an in-process counter for debugging. We avoid echoing during tests.
        static $timesGenerated = 0;
        $timesGenerated++;

        // Use logging to record factory activity without polluting stdout
        Log::debug('HeartrateFactory invocation', ['count' => $timesGenerated]);

        // Ensure there is at least one user to reference. Creating a User when
        // none exist avoids invalid ranges in numberBetween(1, $userCount).
        $userCount = User::count();
        if ($userCount === 0) {
            $created = User::factory()->create();
            $userId = $created->id;
            Log::info('HeartrateFactory created a placeholder User', ['user_id' => $userId]);
        } else {
            // Pick a random existing user id
            $userId = $this->faker->numberBetween(1, $userCount);
        }

        // Return a realistic-looking heartrate reading
        return [
            // Beats per minute with a fractional digit for minor variation
            'rate' => $this->faker->numberBetween(60, 100) . '.' . rand(0, 9),
            // Timestamp of the reading (within this year)
            'time' => $this->faker->dateTimeThisYear(),
            // Associated user id
            'user_id' => $userId,
        ];
    }
}
