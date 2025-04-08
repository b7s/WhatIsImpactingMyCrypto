<?php

namespace Database\Seeders;

use App\Models\BitcoinPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BitcoinPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Base Bitcoin price (current)
        $basePrice = 77294.00;
        
        // Create prices for the last 24 hours
        for ($i = 23; $i >= 0; $i--) {
            $timestamp = now()->subHours($i);
            
            // Random price variation (-1.5% to +1.5%)
            $variation = (mt_rand(-150, 150) / 100);
            $price = $basePrice * (1 + ($variation / 100));
            
            // Add hour-based fluctuation
            $hourFluctuation = sin($timestamp->hour / 24 * 2 * M_PI) * 200;
            $price += $hourFluctuation;
            
            // Round to 2 decimal places
            $price = round($price, 2);
            
            BitcoinPrice::create([
                'price' => $price,
                'price_change_24h' => $variation,
                'volume_24h' => mt_rand(1500000000, 3000000000),
                'market_cap' => $price * 19500000, // ~19.5M BTC in circulation
                'recorded_at' => $timestamp,
            ]);
        }
        
        $this->command->info('Bitcoin price history seeded successfully!');
    }
} 