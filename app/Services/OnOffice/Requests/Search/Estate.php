<?php

namespace App\Services\OnOffice\Requests\Search;

use App\Services\OnOffice\Requests\AbstractRequest;

class Estate extends AbstractRequest
{
    public function __construct($actionId = self::ACTION_ID_GET)
    {
        parent::__construct($actionId, 'search', [], 'estate');
    }

    public function setInput(string $input): Estate
    {
        $this->parameters = ['input' => $input];

        return $this;
    }

    public function setCaseSensitive(bool $caseSensitive = false): Estate
    {
        $this->parameters['casesensitive'] = $caseSensitive;

        return $this;
    }
}
