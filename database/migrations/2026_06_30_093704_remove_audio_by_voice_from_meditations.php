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
            $table->dropColumn('audio_by_voice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meditations', function (Blueprint $table) {
            $table->json('audio_by_voice')->nullable()->after('duration');
        });
    }
};
