<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GetCacheValue::class,
        Commands\FetchSirekapKpuData::class,
        Commands\ForgetCalon::class,
        Commands\UpdateSitemaps::class,
        Commands\ChangeFotoCalon::class,
        Commands\UpdateCalonSitemaps::class,
        // Other commands...
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('cache:clear-expired')->twiceDailyAt(8, 20, 5);
        // $schedule->command('sirekap:fetch')->twiceDailyAt(11, 23, 5);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
