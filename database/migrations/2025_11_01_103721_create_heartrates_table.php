<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `heartrates` table.
 *
 * Stores heart rate readings associated with a `User`. Columns:
 * - `user_id`: foreign key to `users.id`, cascades on delete.
 * - `rate`: floating-point beats-per-minute value.
 * - `time`: time when the reading was taken.
 *
 * The table includes timestamps for created/updated to help with audit and
 * ordering of measurements.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('heartrates', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign key to `users` table. `constrained()` infers `users.id`.
            // `onDelete('cascade')` ensures readings are removed when a user is deleted.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Heart rate value (beats per minute). Use float to allow fractional
            // measurements if desired (e.g., 72.5).
            $table->float('rate');

            // Time of the reading. Stored as `time` type; combine with created_at
            // or use a datetime if you need full date+time semantics.
            $table->time('time');

            // created_at and updated_at timestamps for audit/ordering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the heartrates table when rolling back migrations
        Schema::dropIfExists('heartrates');
    }
};
