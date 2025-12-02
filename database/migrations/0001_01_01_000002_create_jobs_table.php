<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create background job tables.
 *
 * This migration creates three tables used by the application's queue/batch
 * system:
 * - `jobs`: queued jobs awaiting processing
 * - `job_batches`: metadata for grouped jobs (batching)
 * - `failed_jobs`: records of jobs that have failed with exception data
 *
 * These are similar to Laravel's default queue tables; fields are chosen to
 * support queuing, reservation, and basic failure diagnostics.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table storing individual queued jobs
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // Queue name (allows multiple queue channels)
            $table->string('queue')->index();

            // Serialized job payload (class, data, etc.)
            $table->longText('payload');

            // Number of attempts made to run this job
            $table->unsignedTinyInteger('attempts');

            // When the job was reserved (timestamp) by a worker; nullable if not reserved
            $table->unsignedInteger('reserved_at')->nullable();

            // When the job becomes available for processing (timestamp)
            $table->unsignedInteger('available_at');

            // When the job was created (timestamp)
            $table->unsignedInteger('created_at');
        });

        // Batch metadata for grouped jobs. Batching allows grouping many jobs
        // and tracking completion/failure counts and options for the batch.
        Schema::create('job_batches', function (Blueprint $table) {
            // Use string id (UUID) to easily reference batches externally
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');

            // Serialized list of failed job ids for quick inspection
            $table->longText('failed_job_ids');

            // Options/config for the batch (nullable)
            $table->mediumText('options')->nullable();

            // When the batch was cancelled (unix timestamp) or null
            $table->integer('cancelled_at')->nullable();

            // Creation timestamp (unix) for the batch
            $table->integer('created_at');

            // When the batch finished (unix) or null if still running
            $table->integer('finished_at')->nullable();
        });

        // Table for recording failed jobs and exception details for debugging
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            // UUID to correlate failures across systems
            $table->string('uuid')->unique();

            // Connection/driver and queue name where the job was attempted
            $table->text('connection');
            $table->text('queue');

            // Job payload and exception message/trace for diagnostics
            $table->longText('payload');
            $table->longText('exception');

            // Timestamp when job failed; default to current time
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in an order that avoids FK surprises (if added later)
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
    }
};
