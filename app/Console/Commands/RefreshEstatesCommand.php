<?php

namespace App\Console\Commands;

use App\Jobs\ImportEstateData;
use App\Models\Estate;
use Illuminate\Console\Command;

class RefreshEstatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-estates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh estates manually';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Estate::destroy(Estate::all('id'));
        dispatch_sync(new ImportEstateData());
    }
}
