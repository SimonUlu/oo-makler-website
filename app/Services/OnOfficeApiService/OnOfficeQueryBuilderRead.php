<?php

namespace App\Services\OnOfficeApiService;

class OnOfficeQueryBuilderRead extends OnOfficeQueryBuilder
{
    protected $parameters;

    /**
     * OnOfficeQueryBuilderRead constructor.
     */
    public function __construct($resourceType, $listOffset = 0, $listLimit = 500)
    {
        parent::__construct($resourceType, 'read');

        // defaults
        $this->setListLimit($listLimit);
        $this->setListOffset(0);
        $this->setResourceType($resourceType);
    }

    public function render(): self
    {
        $this->parameters = array_filter([
            'data' => $this->data ?? '',
            'modules' => $this->modules ?? '', // this is for getting field configurations
            'realDataTypes' => $this->realDataTypes ?? '', // this is for getting field configurations
            'fieldMeasureFormat' => $this->showFieldMeasureFormat ?? '', // this is for getting field configurations
            'filter' => $this->filter ?? '',
            'sortby' => $this->sortBy ?? '',
            'sortorder' => $this->sortOrder ?? '',
            'listlimit' => $this->listLimit ?? '',
            'listoffset' => $this->listOffset ?? '',
            'fieldList' => $this->fieldList ?? '',
            'parentids' => $this->parentIds ?? '',
            'childids' => $this->childIds ?? '',
            'relationtype' => $this->relationType ?? '',
            'labels' => $this->labels ?? '',
            'language' => $this->language ?? '',
            'showfieldfilters' => $this->showFieldFilters ?? '',
            'addressids' => $this->addressIds ?? '',
            'estateid' => $this->estateId ?? '',
            'actionkind' => $this->actionKind ?? '',
            'actiontype' => $this->actionType ?? '',
        ]);

        return $this;
    }
}
