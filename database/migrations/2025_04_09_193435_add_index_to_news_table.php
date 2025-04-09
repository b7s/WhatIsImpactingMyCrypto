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
        Schema::table('news', function (Blueprint $table) {
            $table->index('title', 'idx_title');
            $table->index('published_at', 'idx_published_at');
            $table->unique(['title', 'url'], 'unique_news_title_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropUnique('unique_news_title_url');
            $table->dropIndex('idx_published_at');
            $table->dropIndex('idx_title');
        });
    }
};
