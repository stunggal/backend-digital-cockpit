<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `bagians` table.
 *
 * The `bagians` table represents hospital departments/sections. Fields are
 * lightweight strings suitable for display and simple lookup. Adjust column
 * lengths/types to match your requirements if you need larger content.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bagians', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Department name (displayable)
            $table->string('nama_bagian');

            // Short code identifying the department (e.g., RAD, ICU)
            $table->string('kode_bagian');

            // Short description or notes about the department
            $table->string('keterangan');

            // Status (e.g., 'Aktif', 'Tidak Aktif')
            $table->string('status');

            // Path or filename for a representative photo/image
            $table->string('foto');

            // Timestamps: created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table when rolling back migrations
        Schema::dropIfExists('bagians');
    }
};
