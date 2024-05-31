<?php

namespace App\Services\OnOfficeApiService;

class OnOfficeQueryBuilderGet extends OnOfficeQueryBuilder
{
    protected $parameters;

    /**
     * OnOfficeQueryBuilderRead constructor.
     */
    public function __construct($resourceType)
    {
        parent::__construct($resourceType, 'get');
        // defaults
        $this->setListLimit(500);
        $this->setListOffset(0);
        $this->setResourceType($resourceType);
    }

    public function render(): self
    {
        $this->parameters = array_filter([
            'relationtype' => $this->relationType ?? '',
            'parentids' => $this->parentIds ?? '',
            'childids' => $this->childIds ?? '',
            'modules' => $this->modules ?? '',
            'showFieldMeasureFormat' => $this->showFieldMeasureFormat ?? '',
            'realDataTypes' => $this->realDataTypes ?? '',
            'dependencies' => $this->showFieldDependencies ?? '',
            'labels' => $this->labels ?? '',
            'estateids' => $this->estateIds ?? '',
            'language' => $this->language ?? '',
            'categories' => $this->categories ?? '',
            'formatOutput' => $this->formatOutput ?? '',
        ]);

        return $this;
    }
}
