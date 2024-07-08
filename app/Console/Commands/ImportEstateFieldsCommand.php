<?php

namespace App\Console\Commands;

use App\Jobs\ImportEstateFields;
use Illuminate\Console\Command;

class ImportEstateFieldsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-estate-fields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import estate fields from onOffice API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Dispatch the job
        ImportEstateFields::dispatch()->onQueue('sync-onoffice');

        $this->info('ImportEstateFieldsSync dispatched');
    }
}
