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
        ImportEstates::dispatchSync($importType);

        $this->info("ImportDataJob dispatched with import type: $importType");
    }
}
