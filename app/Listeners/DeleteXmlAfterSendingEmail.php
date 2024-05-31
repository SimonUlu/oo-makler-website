<?php

namespace App\Listeners;

use App\Events\SendXmlEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteXmlAfterSendingEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(SendXmlEmail $event)
    {
        // Deleting the temporary XML file after sending the email
        if (file_exists($event->xmlFilePath)) {
            unlink($event->xmlFilePath);
        }
    }
}
