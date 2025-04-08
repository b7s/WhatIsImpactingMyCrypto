<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\FetchBitcoinPrice;
use App\Console\Commands\FetchNews;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchNews::class,
        FetchBitcoinPrice::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * These cron jobs are run in the background and do not affect the user experience.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // Fetch news and automatically clear cache every 30 minutes
        $schedule->command('news:fetch')->everyThirtyMinutes();
        
        // Fetch current Bitcoin price every 5 minutes
        $schedule->command('bitcoin:fetch')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 