<?php

namespace App\Console;

use App\Console\Commands\ImportGeoJsonDataFile;
use App\Jobs\ImportEstates;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    // In app/Console/Kernel.php

    protected $commands = [
        ImportGeoJsonDataFile::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ImportEstates('estates_full'), 'sync')->everyFifteenMinutes();
        $schedule->job(new ImportEstates('estates_on_market'), 'sync')->everyFifteenMinutes();
        $schedule->job(new ImportEstates('estates_references'), 'sync')->everyFifteenMinutes();
        // $schedule->command('cache:clear')->daily();
        // $schedule->command('config:cache')->daily();
        // $schedule->command('route:cache')->daily();
        // $schedule->command('statamic:stache:warm')->daily();
        // $schedule->command('statamic:static:clear')->daily();
        // $schedule->command('statamic:static:warm')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
