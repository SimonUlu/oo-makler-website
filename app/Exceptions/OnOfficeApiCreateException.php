<?php

namespace App\Exceptions;

use Exception;

class OnOfficeApiCreateException extends Exception
{
    public function __construct(protected $message)
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'Es ist ein Fehler beim erstellen aufgetreten. Bitte kontaktieren sie uns.'.$this->message;
    }
}
