<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Initial migration for user-related tables.
 *
 * This migration creates three lightweight tables commonly used by the
 * application:
 * - `users`: primary user records used for authentication and profiles.
 * - `password_reset_tokens`: simple table for password reset tokens (email keyed).
 * - `sessions`: session storage for server-side sessions.
 *
 * It also seeds a default `admin` user so a freshly migrated database has
 * at least one administrative account. The seed uses `Hash::make()` for a
 * secure stored password.
 */

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the `users` table that stores authentication identities.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            // When the user's email was verified; nullable for unverified users
            $table->timestamp('email_verified_at')->nullable();
            // Hashed password
            $table->string('password');
            // Convenience remember token used by Laravel's auth system
            $table->rememberToken();
            $table->timestamps();
        });

        // Simple table storing password reset tokens keyed by email. This is
        // not the default Laravel structure but is used in this project.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Email is used as the primary key so lookups are O(1) by email
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Basic session storage table used by the application. The `payload`
        // column stores serialized session data and `last_activity` is used
        // to expire old sessions.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // Optional relation to a user; nullable for guest sessions
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            // Serialized session payload
            $table->longText('payload');
            // Timestamp (unix) of last activity used to expire sessions
            $table->integer('last_activity')->index();
        });

        // Seed a default admin user so newly migrated dev databases have
        // immediate access. Password is hashed with Hash::make. Change the
        // credentials in production setups.
        User::create([
            'name' => 'admin',
            'email' => 'admin@dcfh.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg',
            'role' => 'admin',
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop created tables in reverse order of creation.
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
