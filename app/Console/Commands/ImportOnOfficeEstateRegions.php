<?php

namespace App\Console\Commands;

use App\Jobs\ImportEstateRegions;
use Illuminate\Console\Command;

class ImportOnOfficeEstateRegions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-estate-regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import estate regions from onOffice API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Dispatch the job
        ImportEstateRegions::dispatch()->onQueue('sync-onoffice');

        $this->info('ImportEstateRegionsSync dispatched');
    }
}
