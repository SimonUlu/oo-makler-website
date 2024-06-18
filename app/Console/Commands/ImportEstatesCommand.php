<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportEstates;

class ImportEstatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
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
     *
     * @return int
     */
    public function handle(): int
    {
        $type = $this->argument('type');

        // Dispatch the job synchronously
        ImportEstates::dispatchSync($type);

        $this->info("The ImportEstates job has been dispatched synchronously for type: {$type}");

        return 0;
    }
}
