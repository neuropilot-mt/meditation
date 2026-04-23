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
        Schema::create('provider_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('generation_request_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 40);
            $table->string('operation', 60);
            $table->string('status', 20)->index();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('attempted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_calls');
    }
};
