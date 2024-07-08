<?php

namespace App\Console\Commands;

use App\Jobs\ImportOnOfficeUser;
use Illuminate\Console\Command;

class ImportOnOfficeUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-on-office-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import on office users from onOffice API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Dispatch the job
        ImportOnOfficeUser::dispatchSync();

        $this->info('ImportOnOfficeUsers dispatched');
    }
}
