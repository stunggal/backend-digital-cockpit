<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `pasiens` table (patients).
 *
 * This table stores patient demographics and clinical metadata used by the
 * application. Many fields are stored as strings to match the original
 * project conventions (for example `tgl_masuk` stored as string). If you
 * prefer stricter types (dates/times), consider changing column types to
 * `date`/`datetime` in a future migration.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Basic identity and contact information
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('no_ktp');
            $table->string('no_bpjs');

            // 'L' or 'P' in this project: consider using an enum in the future
            $table->string('jenis_kelamin');

            // Date of birth stored as a date type
            $table->date('tanggal_lahir');

            // Socioeconomic/administrative fields
            $table->string('pekerjaan');

            // Blood group (A, B, AB, O)
            $table->string('golongan_darah');

            // Patient status (nullable for unknown)
            $table->string('status')->nullable();

            // Avatar filename or URL
            $table->string('avatar');

            // Admission date: currently stored as string in this schema
            // (format is up to application code). Consider using `date` if you
            // want database-level date semantics.
            $table->string('tgl_masuk');

            // Discharge date (nullable)
            $table->string('tgl_keluar')->nullable();

            // Room number (string to support alphanumeric room names)
            $table->string('no_kamar');

            // Discharge status (e.g., 'Sembuh', 'Meninggal', etc.)
            $table->string('status_pulang')->nullable();

            // Clinical diagnosis and detailed notes
            $table->string('diagnosa');
            $table->text('deskripsi');

            // created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the table when rolling back.
        Schema::dropIfExists('pasiens');
    }
};
