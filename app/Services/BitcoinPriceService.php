<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BitcoinPrice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BitcoinPriceService
{
    private Client $client;
    
    // Free APIs that provide Bitcoin prices
    private const COINGECKO_API = 'https://api.coingecko.com/api/v3/coins/bitcoin';
    private const COINBASE_API = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
    private const ALTERNATIVE_API = 'https://api.alternative.me/v2/ticker/bitcoin/';
    
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Accept' => 'application/json',
            ],
            'timeout' => 10,
            'connect_timeout' => 5,
            'verify' => false,
        ]);
    }
    
    /**
     * Fetch and save the current Bitcoin price
     *
     * @return BitcoinPrice|null
     */
    public function fetchCurrentPrice(): ?BitcoinPrice
    {
        try {
            // Try to use CoinGecko API first
            $data = $this->fetchFromCoinGecko();
            
            if (!$data) {
                // If that fails, try Coinbase API
                $data = $this->fetchFromCoinbase();
            }
            
            if (!$data) {
                // If both fail, try an alternative API
                $data = $this->fetchFromAlternativeAPI();
            }
            
            if (!$data) {
                Log::error('Failed to get Bitcoin price from all APIs.');
                return null;
            }
            
            // Save to database
            $bitcoinPrice = BitcoinPrice::create([
                'price' => $data['price'],
                'price_change_24h' => $data['price_change_24h'] ?? null,
                'volume_24h' => $data['volume_24h'] ?? null,
                'market_cap' => $data['market_cap'] ?? null,
                'recorded_at' => now(),
            ]);
            
            Log::info('Bitcoin price updated: $' . number_format($data['price'], 2));
            
            return $bitcoinPrice;
        } catch (\Exception $e) {
            Log::error('Error fetching Bitcoin price: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Fetch Bitcoin data from CoinGecko API
     *
     * @return array|null
     */
    private function fetchFromCoinGecko(): ?array
    {
        try {
            $response = $this->client->get(self::COINGECKO_API);
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['market_data']['current_price']['usd'])) {
                return [
                    'price' => $data['market_data']['current_price']['usd'],
                    'price_change_24h' => $data['market_data']['price_change_percentage_24h'] ?? null,
                    'volume_24h' => $data['market_data']['total_volume']['usd'] ?? null,
                    'market_cap' => $data['market_data']['market_cap']['usd'] ?? null,
                ];
            }
        } catch (RequestException $e) {
            Log::warning('Failed to get data from CoinGecko: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Fetch Bitcoin data from Coinbase API
     *
     * @return array|null
     */
    private function fetchFromCoinbase(): ?array
    {
        try {
            $response = $this->client->get(self::COINBASE_API);
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['data']['amount'])) {
                return [
                    'price' => (float) $data['data']['amount'],
                    // Coinbase doesn't provide these data in the basic API
                    'price_change_24h' => null,
                    'volume_24h' => null,
                    'market_cap' => null,
                ];
            }
        } catch (RequestException $e) {
            Log::warning('Failed to get data from Coinbase: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Fetch Bitcoin data from an alternative API
     *
     * @return array|null
     */
    private function fetchFromAlternativeAPI(): ?array
    {
        try {
            $response = $this->client->get(self::ALTERNATIVE_API);
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['data']['1']['quotes']['USD']['price'])) {
                $btcData = $data['data']['1'];
                
                return [
                    'price' => $btcData['quotes']['USD']['price'],
                    'price_change_24h' => $btcData['quotes']['USD']['percentage_change_24h'] ?? null,
                    'volume_24h' => $btcData['quotes']['USD']['volume_24h'] ?? null,
                    'market_cap' => $btcData['quotes']['USD']['market_cap'] ?? null,
                ];
            }
        } catch (RequestException $e) {
            Log::warning('Failed to get data from alternative API: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Clean old data to keep the database optimized
     */
    public function cleanOldData(): void
    {
        // Keep only data from the last 7 days
        BitcoinPrice::where('recorded_at', '<', now()->subDays(7))
            ->delete();
  
        // Reduce data granularity for 2-7 days ago
        // (keep only 1 record per hour)
        $startDate = now()->subDays(7);
        $endDate = now()->subDays(2);

        $hourlyRecords = BitcoinPrice::whereBetween('recorded_at', [$startDate, $endDate])
            ->orderBy('recorded_at')
            ->get()
            ->groupBy(static fn ($item) => $item->recorded_at->format('Y-m-d H:00:00'));

        foreach ($hourlyRecords as $hour => $records) {
            if ($records->count() > 1) {
                // Keep only the middle record of the hour
                $keepIndex = intdiv($records->count(), 2);
                
                foreach ($records as $index => $record) {
                    if ($index !== $keepIndex) {
                        $record->delete();
                    }
                }
            }
        }
    }
} 