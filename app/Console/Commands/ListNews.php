<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class ListNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the latest cryptocurrency news from the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $news = News::orderBy('published_at', 'desc')
            ->take(10)
            ->get();

        if ($news->isEmpty()) {
            $this->info('No news found in the database.');
            return self::SUCCESS;
        }

        $this->info('Latest cryptocurrency news:');
        $this->newLine();

        foreach ($news as $item) {
            $this->info("Title: {$item->title}");
            $this->info("Published: {$item->published_at->diffForHumans()}");
            $this->info("Sentiment: {$item->sentiment}");
            $this->info("URL: {$item->url}");
            $this->newLine();
        }

        return self::SUCCESS;
    }
}
