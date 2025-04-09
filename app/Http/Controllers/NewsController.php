<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BitcoinPrice;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * Keywords to identify political news
     */
    private const POLITICAL_KEYWORDS = [
        'regulation', 'policy', 'government', 'trump', 'biden', 'senate', 'congress',
        'law', 'sec', 'cftc', 'federal', 'reserve', 'fed', 'tax', 'taxes', 'legislation',
        'president', 'minister', 'regulatory', 'compliance', 'legal', 'jpow', 'powell', 
        'war', 'musk', 'china', 'usa'
    ];
    
    /**
     * Cache time in minutes
     */
    private const CACHE_MINUTES = 15;
    
    /**
     * Prefix for cache keys
     */
    private const CACHE_PREFIX = 'news_cache_';
    
    public function index(Request $request): View
    {
        $sentiment = $request->sentiment ?? 'all';
        $timestamp = $request->timestamp ?? '';
        $cacheKey = self::CACHE_PREFIX . 'index_' . $sentiment . '_' . ($timestamp ?: 'latest');
        
        [$news, $sentimentCounts, $politicalNews, $bitcoinData, $latestPrice, $todaySentiment] = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_MINUTES), function () use ($request, $sentiment, $timestamp) {
            $query = News::orderBy('published_at', 'desc');
            
            // Filter by sentiment if requested
            if (in_array($sentiment, ['positive', 'negative', 'neutral'])) {
                $query->where('sentiment', $sentiment);
            }
            
            // Filter by timestamp if provided
            if ($timestamp) {
                $date = \Carbon\Carbon::createFromTimestamp((int) $timestamp);
                $query->where('published_at', '>=', $date->copy()->startOfHour())
                      ->where('published_at', '<=', $date->copy()->endOfHour());
            }
            
            $news = $query->paginate(12);
            
            // Get counts for filter badges
            $sentimentCounts = Cache::remember(self::CACHE_PREFIX . 'sentiment_counts', now()->addMinutes(self::CACHE_MINUTES), function () {
                return [
                    'positive' => News::where('sentiment', 'positive')->count(),
                    'negative' => News::where('sentiment', 'negative')->count(),
                    'neutral' => News::where('sentiment', 'neutral')->count(),
                    'all' => News::count(),
                ];
            });
            
            // Identify political news (4 most recent)
            $politicalNews = $this->getPoliticalNews();
            
            // Get Bitcoin price data for the chart
            $bitcoinData = Cache::remember('bitcoin_prices_24h', now()->addMinutes(5), function () {
                return BitcoinPrice::getLast24Hours();
            });
            
            // Get the latest Bitcoin price
            $latestPrice = Cache::remember('bitcoin_latest_price', now()->addMinutes(5), function () {
                return BitcoinPrice::getLatestPrice();
            });
            
            // Get today's sentiment breakdown
            $todaySentiment = $this->getTodaySentiment();

            return [$news, $sentimentCounts, $politicalNews, $bitcoinData, $latestPrice, $todaySentiment];
        });

        return view('news.index', [
            'news' => $news,
            'sentimentCounts' => $sentimentCounts,
            'currentSentiment' => $sentiment,
            'politicalNews' => $politicalNews,
            'bitcoinPrices' => $bitcoinData,
            'latestBitcoinPrice' => $latestPrice,
            'selectedTimestamp' => $timestamp,
            'todaySentiment' => $todaySentiment,
        ]);
    }
    
    /**
     * Return news for a specific hour
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getNewsByHour(Request $request): JsonResponse
    {
        $timestamp = $request->timestamp;
        
        if (!$timestamp) {
            return response()->json(['error' => 'Timestamp is required'], 400);
        }
        
        $date = \Carbon\Carbon::createFromTimestamp((int) $timestamp);
        
        $news = News::where('published_at', '>=', $date->copy()->startOfHour())
            ->where('published_at', '<=', $date->copy()->endOfHour())
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'published_at' => $item->published_at->diffForHumans(),
                    'sentiment' => $item->sentiment,
                    'url' => $item->getRedirectRoute(),
                ];
            });
            
        return response()->json([
            'news' => $news,
            'count' => $news->count(),
            'hour' => $date->format('H:i'),
            'date' => $date->format('Y-m-d'),
        ]);
    }
    
    /**
     * Get the most recent political news
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPoliticalNews()
    {
        return Cache::remember(self::CACHE_PREFIX . 'political_news', now()->addMinutes(self::CACHE_MINUTES), function () {
            return News::where(function ($query) {
                foreach (self::POLITICAL_KEYWORDS as $keyword) {
                    $query->orWhere('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();
        });
    }
    
    /**
     * Redirect to news URL and increment click counter
     *
     * @param string $encodedId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(string $encodedId): RedirectResponse
    {
        $news = News::findByEncodedId($encodedId);
        
        if (!$news) {
            return redirect()->route('news.index');
        }
        
        $news->increment('clicks');
        
        return redirect()->away($news->url);
    }
    
    /**
     * Clear news-related cache
     *
     * @return void
     */
    public static function clearCache(): void
    {
        // Clear individual cache keys we use
        Cache::forget(self::CACHE_PREFIX . 'sentiment_counts');
        Cache::forget(self::CACHE_PREFIX . 'political_news');
        
        // Clear sentiment-specific caches
        foreach (['all', 'positive', 'negative', 'neutral'] as $sentiment) {
            Cache::forget(self::CACHE_PREFIX . 'index_' . $sentiment);
            Cache::forget(self::CACHE_PREFIX . 'index_' . $sentiment . '_latest');
        }
    }
    
    /**
     * Get the dominant sentiment for the last 24 hours
     * 
     * @return array
     */
    private function getTodaySentiment()
    {
        return Cache::remember(self::CACHE_PREFIX . 'last24h_sentiment', now()->addMinutes(self::CACHE_MINUTES), function () {
            $last24Hours = now()->subHours(24);
            
            // Get news from the last 24 hours
            $recentNews = News::where('published_at', '>=', $last24Hours)->get();
            
            // Initialize counters with weighted calculations
            $counts = [
                'positive' => 0,
                'negative' => 0,
                'neutral' => 0,
            ];
            
            foreach ($recentNews as $news) {
                // Check if this is a political news
                $isPolitical = false;
                foreach (self::POLITICAL_KEYWORDS as $keyword) {
                    if (stripos($news->title, $keyword) !== false || stripos($news->description, $keyword) !== false) {
                        $isPolitical = true;
                        break;
                    }
                }
                
                // Apply weight based on news type
                $weight = $isPolitical ? 2 : 1;
                
                // Apply weighted count
                switch ($news->sentiment) {
                    case 'positive':
                        $counts['positive'] += $weight;
                        break;
                    case 'negative':
                        $counts['negative'] += $weight;
                        break;
                    case 'neutral':
                        $counts['neutral'] += 1; // Always weight of 1 for neutral
                        break;
                }
            }
            
            $total = array_sum($counts);
            if ($total === 0) {
                return [
                    'counts' => $counts,
                    'percentages' => ['positive' => 0, 'negative' => 0, 'neutral' => 0],
                    'dominant' => 'neutral',
                    'weighted' => true
                ];
            }
            
            $percentages = [
                'positive' => round(($counts['positive'] / $total) * 100),
                'negative' => round(($counts['negative'] / $total) * 100),
                'neutral' => round(($counts['neutral'] / $total) * 100),
            ];
            
            // Find the dominant sentiment
            $maxCount = max($counts);
            $dominant = array_search($maxCount, $counts);
            
            return [
                'counts' => $counts,
                'percentages' => $percentages,
                'dominant' => $dominant,
                'total' => $total,
                'weighted' => true
            ];
        });
    }
}
