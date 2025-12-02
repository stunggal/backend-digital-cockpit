<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create simple cache tables used by the application.
 *
 * This file creates two small tables:
 * - `cache`: key/value store for small cached items (string key, mediumText value)
 * - `cache_locks`: lightweight lock table used to coordinate distributed tasks
 *
 * These tables are intentionally minimal and typically used for small,
 * non-persistent caching needs. Adjust types and indices if you move to a
 * production-ready caching strategy.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primary key is the cache key; a mediumText value supports moderate-size blobs.
        // `expiration` stores the unix timestamp (or TTL seconds) for when this cache entry expires.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        // Simple lock table: `key` is the lock name, `owner` identifies who holds the lock,
        // and `expiration` is used to auto-expire abandoned locks.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the lock table before the cache table to avoid FK surprises in future changes.
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
    }
};
