<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\News;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class NewsService
{
    private Client $client;
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36';
    private const RSS_FEEDS = [
        'https://news.google.com/rss/search?q=bitcoin+price+movement&hl=en-US&gl=US&ceid=US:en',
        'https://news.google.com/rss/search?q=cryptocurrency+stablecoins+market&hl=en-US&gl=US&ceid=US:en',
        'https://news.google.com/rss/search?q=bitcoin+analysis&hl=en-US&gl=US&ceid=US:en',
        'https://news.google.com/rss/search?q=global+trade+regulation+policy+government&hl=en-US&gl=US&ceid=US:en',
        'https://news.google.com/rss/search?q=global+economy+tax&hl=en-US&gl=US&ceid=US:en'
    ];

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => self::USER_AGENT,
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
            ],
            'timeout' => 10,
            'connect_timeout' => 5,
            'verify' => false,
        ]);
    }

    public function fetchNews(): void
    {
        $fetchedCount = 0;
        
        foreach (self::RSS_FEEDS as $feedUrl) {
            try {
                $response = $this->client->get($feedUrl);
                $xml = simplexml_load_string($response->getBody()->getContents());
                
                if (!$xml || !isset($xml->channel->item)) {
                    continue;
                }

                foreach ($xml->channel->item as $item) {
                    $result = $this->processNewsItem($item);
                    if ($result) {
                        $fetchedCount++;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching news from ' . $feedUrl . ': ' . $e->getMessage());
            }
        }
        
        if ($fetchedCount === 0) {
            Log::warning('No new articles were fetched.');
        }
    }

    private function processNewsItem(\SimpleXMLElement $item): bool
    {
        try {
            // Extract the title, removing source if it's in the format "Title - Source"
            $title = (string) $item->title;
            $googleUrl = (string) $item->link;
            
            // Extract source from title if available (format: "Title - Source")
            $sourceParts = explode(' - ', $title);
            if (count($sourceParts) > 1) {
                $source = end($sourceParts);
                // Clean up the title by removing the source
                $title = implode(' - ', array_slice($sourceParts, 0, -1));
            } else {
                $source = (string) $item->source ?: 'Unknown Source';
            }
            
            $description = strip_tags((string) $item->description);
            $publishedAt = Carbon::parse((string) $item->pubDate);
            
            // Extract actual source URL from Google News URL
            $originalUrl = $this->extractOriginalUrl($googleUrl);
            
            // Create a domain URL if original extraction failed
            $domainName = strtolower(trim($source));
            $domainName = preg_replace('/\s+/', '', $domainName);
            if (empty($originalUrl)) {
                // Try to guess the domain based on the source
                if (!Str::contains($domainName, '.')) {
                    $domainName = $domainName . '.com';
                }
                $originalUrl = 'https://' . $domainName;
            }
            
            // Skip if older than 5 days to focus on fresh news
            if ($publishedAt->diffInDays(now()) > 5) {
                return false;
            }
            
            // Check if news already exists with this title or URL
            if (News::where('url', $originalUrl)->orWhere('title', $title)->exists()) {
                return false;
            }

            // Analyze sentiment
            $sentiment = $this->analyzeSentiment($title . ' ' . $description);

            // Create news entry
            News::create([
                'title' => $title,
                'description' => $description ?: Str::limit($title, 150),
                'url' => $originalUrl,
                'source' => $source,
                'sentiment' => $sentiment,
                'published_at' => $publishedAt,
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error processing news item: ' . $e->getMessage());
            return false;
        }
    }
    
    private function extractOriginalUrl(string $googleUrl): string
    {
        try {
            // First, try to extract the URL from the query parameters
            $parsedUrl = parse_url($googleUrl);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
                if (isset($queryParams['url'])) {
                    return $queryParams['url'];
                }
            }
            
            // If that doesn't work, try to follow the redirect
            try {
                $response = $this->client->get($googleUrl, [
                    'allow_redirects' => false,
                ]);
                
                if ($response->getStatusCode() === 302 || $response->getStatusCode() === 301) {
                    $location = $response->getHeaderLine('Location');
                    if (!empty($location)) {
                        return $location;
                    }
                }
                
                // If no redirection, try to extract from HTML content
                $html = (string) $response->getBody();
                return $this->extractUrlFromHtml($html, $googleUrl);
                
            } catch (RequestException $e) {
                // Sometimes Google uses JavaScript redirection
                if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 200) {
                    $html = (string) $e->getResponse()->getBody();
                    $extractedUrl = $this->extractUrlFromHtml($html, $googleUrl);
                    if (!empty($extractedUrl)) {
                        return $extractedUrl;
                    }
                }
            }
            
            return '';
        } catch (\Exception $e) {
            Log::warning('Failed to extract original URL: ' . $e->getMessage());
            return '';
        }
    }
    
    private function extractUrlFromHtml(string $html, string $googleUrl): string
    {
        // Try to extract URL from a meta refresh tag or javascript redirect
        if (preg_match('/window\.location\s*=\s*[\'"]([^\'"]+)[\'"]/', $html, $matches)) {
            return $matches[1];
        }
        
        if (preg_match('/<meta[^>]*?url=([^"\']*)/', $html, $matches)) {
            return $matches[1];
        }
        
        // Try to find an article URL
        if (preg_match('/<a[^>]*?href=["\'](https?:\/\/[^"\']*?)["\'][^>]*?>(article|read|full|story)/i', $html, $matches)) {
            if (strpos($matches[1], 'google') === false) {
                return $matches[1];
            }
        }
        
        // Try to find a canonical link
        if (preg_match('/<link[^>]*?rel=["\'](canonical)["\'][^>]*?href=["\'](https?:\/\/[^"\']*?)["\']/', $html, $matches)) {
            return $matches[2];
        }
        
        // Find any non-Google outbound link
        if (preg_match_all('/<a[^>]*?href=["\'](https?:\/\/[^"\']*?)["\'][^>]*?>/', $html, $matches)) {
            foreach ($matches[1] as $match) {
                if (strpos($match, 'google') === false && 
                    strpos($match, 'gstatic') === false && 
                    strpos($match, 'youtube') === false) {
                    return $match;
                }
            }
        }
        
        return '';
    }

    private function analyzeSentiment(string $text): string
    {
        $positiveWords = [
            'up', 'rise', 'surge', 'gain', 'bullish', 'positive', 'increase', 
            'rally', 'soar', 'growth', 'climbing', 'outperform', 'recovery',
            'rebound', 'boom', 'breakthrough', 'opportunity', 'optimistic',
            'potential', 'promising', 'support', 'uptrend', 'profitable',
            'success', 'momentum', 'expand', 'higher', 'upside',
            'pause', 'pauses', 'cancel', 'tariff', 'tariffs',
        ];
        
        $negativeWords = [
            'down', 'fall', 'drop', 'decline', 'bearish', 'negative', 'decrease',
            'crash', 'plunge', 'plummet', 'slide', 'slump', 'tumble', 'correction',
            'risk', 'fear', 'crisis', 'trouble', 'worry', 'concern', 'liquidation',
            'sell-off', 'downtrend', 'selling', 'pressure', 'oversold', 'warning',
            'threat', 'struggling', 'loses', 'loss', 'lower'
        ];

        $text = strtolower($text);
        $positiveCount = 0;
        $negativeCount = 0;

        foreach ($positiveWords as $word) {
            $positiveCount += substr_count($text, $word);
        }

        foreach ($negativeWords as $word) {
            $negativeCount += substr_count($text, $word);
        }

        if ($positiveCount > $negativeCount) {
            return 'positive';
        } elseif ($negativeCount > $positiveCount) {
            return 'negative';
        }

        return 'neutral';
    }
} 