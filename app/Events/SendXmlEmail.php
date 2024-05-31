<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendXmlEmail
{
    use Dispatchable, SerializesModels;

    public $xmlFilePath;

    /**
     * Create a new event instance.
     */
    public function __construct(string $xmlFilePath)
    {
        $this->xmlFilePath = $xmlFilePath;
    }
}
