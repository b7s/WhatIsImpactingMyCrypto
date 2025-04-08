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
        Schema::create('bitcoin_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 12, 2); // Price in USD
            $table->decimal('price_change_24h', 8, 2)->nullable(); // 24h percentage change
            $table->decimal('volume_24h', 20, 2)->nullable(); // Trading volume in USD
            $table->decimal('market_cap', 20, 2)->nullable(); // Market capitalization
            $table->timestamp('recorded_at')->index(); // Time when the price was recorded
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitcoin_prices');
    }
};
