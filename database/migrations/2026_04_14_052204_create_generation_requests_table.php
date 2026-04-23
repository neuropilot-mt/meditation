<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('public_id', 26)->unique();
            $table->string('client_id', 120)->index();
            $table->string('idempotency_key', 120)->nullable();
            $table->string('type', 20);
            $table->string('status', 20)->default('queued')->index();
            $table->string('provider_preference', 40)->nullable();
            $table->string('selected_provider', 40)->nullable();
            $table->json('input');
            $table->json('options')->nullable();
            $table->string('webhook_url')->nullable();
            $table->unsignedBigInteger('result_asset_id')->nullable()->index();
            $table->string('error_code', 50)->nullable();
            $table->text('error_message')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['client_id', 'idempotency_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generation_requests');
    }
};
