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
        // SQLite doesn't support multiple ALTER commands in one statement well,
        // and doesn't support dropping foreign keys. We need to recreate the table.
        // For MySQL/PostgreSQL we could use individual column operations.

        Schema::table('meditations', function (Blueprint $table) {
            // Drop foreign key first (if exists) — safe for MySQL/PostgreSQL
            // For SQLite this will be handled by table recreation
            try {
                $table->dropForeign(['category_id']);
            } catch (Exception $e) {
                // Foreign key might not exist or SQLite doesn't support dropForeign
            }
        });

        // For SQLite: recreate table with new schema
        // For MySQL/PostgreSQL: we can alter columns directly
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            $this->recreateTableForSQLite();
        } else {
            $this->alterTableForMysql();
        }
    }

    /**
     * Recreate meditations table for SQLite (no dropColumn support for most cases).
     */
    protected function recreateTableForSQLite(): void
    {
        // 1. Create new table with desired schema
        Schema::create('meditations_new', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['wake_up', 'productivity', 'sleep']);
            $table->integer('duration');
            $table->json('audio_by_voice');
            $table->string('image_url');
            $table->enum('access_type', ['free', 'rewarded']);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Copy data from old table if it exists and has the old columns
        $oldColumns = Schema::getColumnListing('meditations');

        if (in_array('category_id', $oldColumns)) {
            // Old schema — we can't migrate data meaningfully because
            // category_id -> category enum and audio_url -> audio_by_voice json
            // are breaking changes. Just drop old data.
            // If you need to preserve data, implement custom mapping logic here.
        }

        // 3. Drop old table and rename new one
        Schema::dropIfExists('meditations');
        Schema::rename('meditations_new', 'meditations');
    }

    /**
     * Alter meditations table for MySQL/PostgreSQL.
     */
    protected function alterTableForMysql(): void
    {
        Schema::table('meditations', function (Blueprint $table) {
            // Change id from uuid to string
            $table->string('id')->change();

            // Drop old columns
            $table->dropColumn([
                'category_id',
                'tags',
                'audio_url',
                'preview_audio_url',
            ]);

            // Add new columns
            $table->enum('category', ['wake_up', 'productivity', 'sleep'])->after('description');
            $table->json('audio_by_voice')->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::create('meditations_old', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->text('description');
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
                $table->json('tags');
                $table->integer('duration');
                $table->string('audio_url');
                $table->string('image_url');
                $table->string('access_type');
                $table->string('preview_audio_url')->nullable();
                $table->integer('sort_order');
                $table->timestamps();
            });

            Schema::dropIfExists('meditations');
            Schema::rename('meditations_old', 'meditations');
        } else {
            Schema::table('meditations', function (Blueprint $table) {
                $table->dropColumn(['category', 'audio_by_voice']);
                $table->uuid('id')->change();
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
                $table->json('tags');
                $table->string('audio_url');
                $table->string('preview_audio_url')->nullable();
            });
        }
    }
};
