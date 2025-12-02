<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the `personal_access_tokens` table used by Laravel
 * Sanctum/Personal Access Tokens. Each token is polymorphically related to a
 * "tokenable" model (for example a `User`), so the table includes the
 * standard `morphs` columns (`tokenable_type` and `tokenable_id`).
 *
 * Columns:
 * - `name`: human-friendly label for the token (e.g. "My mobile app")
 * - `token`: the actual token string (64 chars) stored hashed by application
 * - `abilities`: JSON/text describing scopes/abilities granted to the token
 * - `last_used_at`: when the token was last used
 * - `expires_at`: optional expiry timestamp (indexed for efficient cleanup)
 *
 * The migration uses `timestamps()` to track creation/update times.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the table holding personal access tokens for tokenable models
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Polymorphic relation fields: tokenable_type (string) and tokenable_id (unsignedBigInteger)
            // This allows attaching tokens to different models (e.g., User)
            $table->morphs('tokenable');

            // Human-readable name for the token (not secret)
            $table->text('name');

            // The token string (stored by default as plain here because hashing is handled
            // by the application logic when issuing tokens). Keep length 64 to match
            // typical Sanctum implementations.
            $table->string('token', 64)->unique();

            // Abilities (scopes) granted to this token. Nullable for tokens with full access.
            $table->text('abilities')->nullable();

            // When the token was last used (nullable for never-used tokens)
            $table->timestamp('last_used_at')->nullable();

            // Optional expiry timestamp; indexed to allow efficient expiry checks/cleanup
            $table->timestamp('expires_at')->nullable()->index();

            // Created_at and updated_at timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table when rolling back
        Schema::dropIfExists('personal_access_tokens');
    }
};
