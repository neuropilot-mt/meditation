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
        Schema::create('intake_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('public_id', 26)->unique();
            $table->string('client_id', 120)->index();
            $table->unsignedTinyInteger('age');
            $table->string('emotional_state', 120);
            $table->text('preferences')->nullable();
            $table->string('language', 10)->default('en');
            $table->unsignedTinyInteger('target_duration_minutes')->default(10);
            $table->json('questionnaire');
            $table->text('image_prompt');
            $table->text('audio_prompt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_submissions');
    }
};
