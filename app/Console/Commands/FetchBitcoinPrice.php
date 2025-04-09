<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\NewsController;
use App\Services\BitcoinPriceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchBitcoinPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitcoin:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store current Bitcoin price';

    /**
     * Execute the console command.
     */
    public function handle(BitcoinPriceService $bitcoinService): int
    {
        $this->info('Fetching current Bitcoin price...');
        
        try {
            $bitcoinPrice = $bitcoinService->fetchCurrentPrice();
            
            if (!$bitcoinPrice) {
                $this->error('Failed to fetch Bitcoin price from APIs.');
                return self::FAILURE;
            }
                        
            // Clear Bitcoin cache to ensure the chart displays updated data
            $this->clearBitcoinCache();
            
            // Every 12 hours, clean old data to optimize the database
            if (now()->hour % 12 === 0 && now()->minute < 5) {
                $bitcoinService->cleanOldData();
            }
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error fetching Bitcoin price: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
    
    /**
     * Clear Bitcoin price related cache
     */
    private function clearBitcoinCache(): void
    {
        Cache::forget('bitcoin_prices_24h');
        Cache::forget('bitcoin_latest_price');
    }
}
