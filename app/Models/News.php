<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\IdEncoder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'source',
        'sentiment',
        'clicks',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'clicks' => 'integer',
    ];
    
    /**
     * Get YouTube-style encoded ID
     *
     * @return string
     */
    public function getEncodedId(): string
    {
        return IdEncoder::encode($this->id);
    }
    
    /**
     * Find a news item by encoded ID
     *
     * @param string $encodedId
     * @return self|null
     */
    public static function findByEncodedId(string $encodedId): ?self
    {
        try {
            $id = IdEncoder::decode($encodedId);
            return self::find($id);
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Get redirect route using the encoded ID
     *
     * @return string
     */
    public function getRedirectRoute(): string
    {
        return route('news.redirect', $this->getEncodedId());
    }
}
