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
        Schema::table('meditations', function (Blueprint $table) {
            $table->string('audio_url')->nullable()->after('duration');
        });

        Schema::create('meditation_voice', function (Blueprint $table) {
            $table->string('meditation_id');
            $table->string('voice_id');
            $table->string('audio_url');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->primary(['meditation_id', 'voice_id']);
            $table->foreign('meditation_id')->references('id')->on('meditations')->cascadeOnDelete();
            $table->foreign('voice_id')->references('id')->on('voices')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meditation_voice');

        Schema::table('meditations', function (Blueprint $table) {
            $table->dropColumn('audio_url');
        });
    }
};
