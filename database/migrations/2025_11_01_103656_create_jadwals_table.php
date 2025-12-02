<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `jadwals` table (appointments/schedule entries).
 *
 * Each record links a doctor (`dokter_id`) and a patient (`pasien_id`) to an
 * event at a specific date and time. The migration leaves commented unique
 * constraints that you can enable later to prevent double-booking.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign key to doctors table. Constrained to `dokters.id`.
            // Consider adding `->onDelete('cascade')` if you want jadwals
            // removed when a dokter is deleted.
            $table->foreignId('dokter_id')->constrained('dokters');

            // Foreign key to patients table. Constrained to `pasiens.id`.
            $table->foreignId('pasien_id')->constrained('pasiens');

            // Short description of the scheduled event (e.g., 'Check-up Rutin')
            $table->string('event');

            // Date and time of the appointment
            $table->date('tanggal');
            $table->time('jam');

            // Optional status field (e.g., 'Menunggu', 'Diperiksa', 'Selesai')
            $table->string('status')->nullable();

            // Notes or detailed description for the appointment
            $table->text('catatan')->nullable();

            // Optional uniqueness constraints to prevent double-booking. They
            // are commented out by default; enable if your business rules
            // require enforcing these at the database level.
            // $table->unique(['dokter_id', 'tanggal', 'jam']);
            // $table->unique(['pasien_id', 'tanggal', 'jam']);

            // created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the jadwals table when rolling back migrations
        Schema::dropIfExists('jadwals');
    }
};
