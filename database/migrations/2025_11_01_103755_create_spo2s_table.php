<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `spo2s` table (oxygen saturation readings).
 *
 * Stores SPO2 measurements associated with a `User`. Columns:
 * - `user_id`: foreign key to `users.id`, cascades on delete.
 * - `oxygen`: integer percent value (typically 90-100).
 * - `time`: time of the measurement (use `timestamp` if full datetime is required).
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spo2s', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Link to user that owns this reading. Using `constrained()` for `users.id`.
            // `onDelete('cascade')` removes readings when the user is deleted.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Oxygen saturation percentage (integer). Typical resting values are 90-100.
            $table->integer('oxygen');

            // Time of the measurement. If you need date+time, consider using
            // `timestamp('measured_at')` instead of `time`.
            $table->time('time');

            // Timestamps for record creation/update
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the table when rolling back migrations
        Schema::dropIfExists('spo2s');
    }
};
