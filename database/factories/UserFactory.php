<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
/**
 * Factory for creating `User` model test data.
 *
 * Caches a hashed default password to avoid repeated hashing during a single
 * process. Provides a convenience `unverified()` state helper and a
 * `withPassword()` helper to create users with a known password for tests.
 */
class UserFactory extends Factory
{
    /**
     * Cached hashed password for this PHP process.
     *
     * When creating many users in a single seed/test run we avoid re-hashing
     * the literal `password` string repeatedly by storing the hashed result
     * here. This is purely an optimization for test/seed performance.
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * Returns attributes to create a `User`. The default password is the
     * hashed form of the literal string `password` (cached in
     * `self::$password`). Use `withPassword()` to override this when you need
     * a specific password in tests.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Human name for display/login
            'name' => fake()->name(),

            // Unique safe email address
            'email' => fake()->unique()->safeEmail(),

            // Marked verified by default; call `unverified()` to unset
            'email_verified_at' => now(),

            // Cached hashed password for the known literal 'password'
            'password' => static::$password ??= Hash::make('password'),

            // Remember token used by authentication guards
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Set a specific plain-text password for the generated user.
     *
     * Example: `User::factory()->withPassword('secret')->create()`
     *
     * @param string $plainPassword
     * @return static
     */
    public function withPassword(string $plainPassword): static
    {
        return $this->state(fn(array $attributes) => [
            'password' => Hash::make($plainPassword),
        ]);
    }
}
