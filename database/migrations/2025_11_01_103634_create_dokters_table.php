<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `dokters` table (doctors).
 *
 * Each dokter record stores basic profile information and is linked to a
 * `User` account via a foreign key (`user_id`). The `onDelete('cascade')`
 * ensures that when the linked user is removed, the dokter record is also
 * removed to keep the database consistent.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokters', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Doctor's full name
            $table->string('nama');

            // Contact address
            $table->string('alamat');

            // Phone number
            $table->string('no_telp');

            // National ID or identity number
            $table->string('no_ktp');

            // Gender ('L' or 'P' in this project)
            $table->string('jenis_kelamin');

            // Date of birth
            $table->date('tanggal_lahir');

            // Medical specialty (e.g., 'Umum', 'Gigi')
            $table->string('spesialis');

            // Status string, e.g., 'Aktif' or 'Tidak Aktif'
            $table->string('status');

            // Avatar filename or URL
            $table->string('avatar');

            // Link to the user account that owns this dokter profile. The
            // `constrained('users')` call adds a foreign key reference to
            // `users.id`. `onDelete('cascade')` removes the dokter when the
            // related user is deleted.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table when rolling back migrations
        Schema::dropIfExists('dokters');
    }
};
