<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsController;
use App\Services\NewsService;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest cryptocurrency news from various sources';

    /**
     * Execute the console command.
     */
    public function handle(NewsService $newsService): int
    {
        $this->info('Fetching cryptocurrency news...');
        
        try {
            $newsService->fetchNews();
            
            // Limpar o cache para que novos dados sejam carregados
            NewsController::clearCache();
            $this->info('Cache cleared to reflect new data.');
            
            $this->info('News fetched successfully!');
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error fetching news: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
