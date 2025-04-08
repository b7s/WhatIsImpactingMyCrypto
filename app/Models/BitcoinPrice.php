<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitcoinPrice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'price',
        'price_change_24h',
        'volume_24h',
        'market_cap',
        'recorded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'price_change_24h' => 'float',
        'volume_24h' => 'float',
        'market_cap' => 'float',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get Bitcoin prices for the last 24 hours grouped by hour
     *
     * @return array
     */
    public static function getLast24Hours(): array
    {
        $prices = self::where('recorded_at', '>=', now()->subHours(24))
            ->orderBy('recorded_at', 'asc')
            ->get();

        $hourlyPrices = [];
        $hours = [];

        // Create an array with all hours from the last 24 hours
        for ($i = 24; $i >= 0; $i--) {
            $hour = now()->subHours($i)->startOfHour();
            $hourKey = $hour->format('Y-m-d H:00');
            $hours[$hourKey] = [
                'hour' => $hour->format('H:00'),
                'timestamp' => $hour->timestamp,
                'price' => null,
                'formatted_price' => null,
            ];
        }

        // Fill in prices for each hour
        foreach ($prices as $price) {
            $hourKey = $price->recorded_at->format('Y-m-d H:00');
            
            if (isset($hours[$hourKey]) && $hours[$hourKey]['price'] === null) {
                $hours[$hourKey]['price'] = $price->price;
                $hours[$hourKey]['formatted_price'] = '$' . number_format($price->price, 2);
            }
        }

        // Convert to sequential array and fill null values
        $result = array_values($hours);
        $lastValidPrice = null;

        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['price'] === null) {
                $result[$i]['price'] = $lastValidPrice;
                $result[$i]['formatted_price'] = $lastValidPrice ? '$' . number_format($lastValidPrice, 2) : null;
            } else {
                $lastValidPrice = $result[$i]['price'];
            }
        }

        return $result;
    }

    /**
     * Returns the latest recorded Bitcoin price
     *
     * @return self|null
     */
    public static function getLatestPrice(): ?self
    {
        return self::orderBy('recorded_at', 'desc')->first();
    }
}
