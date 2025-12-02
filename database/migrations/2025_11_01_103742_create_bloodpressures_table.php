<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `bloodpressures` table.
 *
 * Stores systolic/diastolic blood pressure readings tied to a `User`.
 * Columns:
 * - `user_id`: foreign key to `users.id`, cascades on delete so readings
 *    are removed when the user is deleted.
 * - `systolic` / `diastolic`: integer mmHg values representing the reading.
 * - `time`: time of the measurement; combine with `created_at` or use a
 *    datetime if you need full timestamp semantics.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bloodpressures', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Link to user that owns this reading. `constrained()` points to `users.id`.
            // `onDelete('cascade')` removes readings when the user is deleted.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Systolic and diastolic pressure (mmHg)
            $table->integer('systolic');
            $table->integer('diastolic');

            // Time of the reading. Use `time` if date is stored elsewhere or
            // readings are grouped by day; consider `timestamp` if you need
            // full date+time per reading.
            $table->time('time');

            // created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the bloodpressures table when rolling back migrations
        Schema::dropIfExists('bloodpressures');
    }
};
