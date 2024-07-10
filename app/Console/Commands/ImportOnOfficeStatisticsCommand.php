<?php

namespace App\Console\Commands;

use App\Jobs\ImportStatisticsDataForEntries;
use Illuminate\Console\Command;

class ImportOnOfficeStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-on-office-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import on office statistics from onOffice API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ImportStatisticsDataForEntries::dispatch()->onQueue('sync-onoffice');

        $this->info('ImportStatisticsDataForEntries dispatched');
    }
}
