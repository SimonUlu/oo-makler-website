<?php

namespace App\Services\OnOffice\Requests\Search;

use App\Services\OnOffice\Requests\AbstractRequest;

class Address extends AbstractRequest
{
    public function __construct($actionId = self::ACTION_ID_GET)
    {
        parent::__construct($actionId, 'search', [], 'address');
    }

    public function setInput(string $input): Address
    {
        $this->parameters = ['input' => $input];

        return $this;
    }

    public function setCaseSensitive(bool $caseSensitive = false): Address
    {
        $this->parameters['casesensitive'] = $caseSensitive;

        return $this;
    }
}
