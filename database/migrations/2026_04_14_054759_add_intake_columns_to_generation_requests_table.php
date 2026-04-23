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
        Schema::table('generation_requests', function (Blueprint $table) {
            $table->foreignId('intake_submission_id')
                ->nullable()
                ->after('client_id')
                ->constrained()
                ->nullOnDelete();
            $table->string('purpose', 40)->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generation_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('intake_submission_id');
            $table->dropColumn('purpose');
        });
    }
};
