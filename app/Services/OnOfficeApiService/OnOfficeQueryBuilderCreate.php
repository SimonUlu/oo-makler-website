<?php

namespace App\Services\OnOfficeApiService;

class OnOfficeQueryBuilderCreate extends OnOfficeQueryBuilder
{
    protected $parameters;

    /**
     * OnOfficeQueryBuilderRead constructor.
     */
    public function __construct($resourceType)
    {
        parent::__construct($resourceType, 'create');
        // defaults
        $this->setResourceType($resourceType);
    }

    public function render(): self
    {
        $this->parameters = array_filter([
            'data' => $this->data ?? '',
            'relationtype' => $this->relationType ?? '',
            'parentid' => $this->parentIds ?? '',
            'childid' => $this->childIds ?? '',
            'relatedEstateId' => $this->relatedEstateId ?? '',
            'relatedAddressId' => $this->relatedAddressId ?? '',
            'subscribers' => $this->relatedSubscriberId ?? '',
            'addressids' => $this->addressIds ?? '',
            'addressid' => $this->addressId ?? '',
            'advisor' => $this->advisorId ?? '',
            'estateid' => $this->estateId ?? '',
            'actionkind' => $this->actionKind ?? '',
            'actiontype' => $this->actionType ?? '',
            'note' => $this->note ?? '',
        ]);

        if ($this->resourceType == 'address') {
            $this->parameters = $this->parameters['data'];
        }

        return $this;
    }
}
