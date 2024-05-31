<?php

namespace App\Exceptions;

use Exception;

class OnOfficeApiModifyException extends Exception
{
    public function __construct(protected $message)
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'Es ist ein Fehler beim modifizieren aufgetreten. Bitte kontaktieren sie uns.'.$this->message;
    }
}
