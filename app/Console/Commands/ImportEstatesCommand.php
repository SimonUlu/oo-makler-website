<?php

namespace App\Console\Commands;

use App\Jobs\ImportEstates;
use Illuminate\Console\Command;

class ImportEstatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *             possibles values: 'estate_entries', 'estate_entries_full'
     */
    protected $signature = 'import:estates {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the ImportEstates job synchronously';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');

        // Dispatch the job synchronously
        ImportEstates::dispatch($type)->onQueue('sync-onoffice');

        $this->info("The ImportEstates job has been dispatched synchronously for type: {$type}");

        return 0;
    }
}
