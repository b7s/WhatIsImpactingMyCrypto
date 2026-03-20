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
            $table->index('sentiment', 'idx_sentiment');
            $table->index(['published_at', 'sentiment'], 'idx_published_at_sentiment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('idx_published_at_sentiment');
            $table->dropIndex('idx_sentiment');
        });
    }
};