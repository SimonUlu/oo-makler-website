<?php

namespace App\Console\Commands;

use App\Jobs\ImportEstates;
use Illuminate\Console\Command;

class RefreshEstatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     *              possibles values: 'estates_on_market', 'estate_entries', 'estate_entries_full'
     */
    protected $signature = 'app:refresh-estates {importType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh estates manually';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $importType = $this->argument('importType');

        // Dispatch the job
        ImportEstates::dispatch($importType)->onQueue('sync-onoffice');

        $this->info("ImportDataJob dispatched with import type: $importType");
    }
}
