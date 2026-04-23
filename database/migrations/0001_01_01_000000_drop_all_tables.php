<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop all existing tables to ensure a clean slate before running migrations.
     *
     * This migration runs first (timestamp 0001_01_01_000000) and safely drops
     * every application table using dropIfExists(), so it is a no-op on a fresh
     * database and a clean reset on one that already has tables from a previous
     * setup (e.g. a prior SQLite installation).
     *
     * Tables are dropped in an order that respects foreign-key constraints:
     * child/dependent tables are dropped before the parent tables they reference.
     */
    public function up(): void
    {
        // Dependent tables first (reference generation_requests or categories)
        Schema::dropIfExists('assets');
        Schema::dropIfExists('provider_calls');
        Schema::dropIfExists('intake_submissions');
        Schema::dropIfExists('meditations');
        Schema::dropIfExists('generation_requests');

        // Stand-alone application tables
        Schema::dropIfExists('categories');

        // Laravel framework tables
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }

    /**
     * This migration is intentionally irreversible — its sole purpose is to
     * clear the way for subsequent migrations on a pre-populated database.
     */
    public function down(): void
    {
        //
    }
};
