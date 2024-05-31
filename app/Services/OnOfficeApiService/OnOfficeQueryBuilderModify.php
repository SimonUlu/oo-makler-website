<?php

namespace App\Services\OnOfficeApiService;

class OnOfficeQueryBuilderModify extends OnOfficeQueryBuilder
{
    protected $parameters;

    /**
     * OnOfficeQueryBuilderRead constructor.
     */
    public function __construct($resourceType)
    {
        parent::__construct($resourceType, 'modify');
    }

    public function render(): self
    {
        if ($this->resourceType == 'address') {
            foreach ($this->data as $key => $val) {
                $params[$key] = $val;
            }
            $this->parameters = $params ?? '';
        } else {
            $this->parameters = array_filter([
                'data' => $this->data ?? '',
            ]);
        }

        return $this;
    }
}
