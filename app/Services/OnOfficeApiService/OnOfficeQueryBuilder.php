<?php

namespace App\Services\OnOfficeApiService;

class OnOfficeQueryBuilder extends AbstractRequest
{
    protected array $modules;

    protected int $listOffset;

    protected int $listLimit;

    protected $parameters;

    protected $resourceType;

    protected $data;

    protected bool $realDataTypes;

    protected bool $showFieldMeasureFormat;

    protected $field;

    protected array $filter;

    protected $relationType;

    protected $parentIds;

    protected int $relatedEstateId;

    protected int $relatedAddressId;

    protected int $advisorId;

    protected array $relatedSubscriberId;

    protected array $addressIds;

    protected int $addressId;

    protected int $estateId;

    protected $allEntries;

    protected string $actionKind;

    protected string $actionType;

    protected string $note;

    protected array $childIds;

    protected array $estateIds;

    protected array $categories;

    protected string $language;

    protected bool $labels;

    protected bool $showFieldFilters;

    protected string $sortOrder;

    protected string $sortBy;

    protected bool $showFieldDependencies;

    protected bool $showOnlyInactive;

    protected array $fieldList;

    protected bool $formatOutput;

    /**
     * OnOfficeQueryBuilder constructor.
     */
    public function __construct($resourceType, $action)
    {
        if ($action == 'create') {
            switch ($resourceType) {
                default:
                    parent::__construct(self::ACTION_ID_CREATE, $resourceType);
                    break;
            }
        }
        if ($action == 'modify') {
            switch ($resourceType) {
                default:
                    parent::__construct(self::ACTION_ID_MODIFY, $resourceType);
                    break;
            }
        }
        if ($action == 'read' || $action == 'get') {
            switch ($resourceType) {
                case 'estate':
                case 'address':
                case 'agentslog':
                case 'task':
                case 'calendar':
                case 'users':
                case 'user':
                    parent::__construct(self::ACTION_ID_READ, $resourceType);
                    break;
                case 'regions':
                case 'fields':
                case 'estatepictures':
                    parent::__construct(self::ACTION_ID_GET, $resourceType);
                    break;
                case 'idsfromrelation':
                case 'estate_owner':
                    parent::__construct(self::ACTION_ID_GET, 'idsfromrelation');
            }
        }

        // defaults
        $this->setListLimit(500);
        $this->setListOffset(0);
        $this->setResourceType($resourceType);
    }

    /*
    public function setFilter(string $column, array $filter): OnOfficeQueryBuilder
    {
        $this->filter[$column] = $filter;
        return $this;
    }
    */

    public function setFilter(array $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function setShowFieldMeasureFormat(bool $showFieldMeasureFormat): self
    {
        $this->showFieldMeasureFormat = $showFieldMeasureFormat;

        return $this;
    }

    public function setResourceType(string $resourceType): self
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getAllEntries(bool $allEntries = true): self
    {
        $this->allEntries = $allEntries;

        return $this;
    }

    public function setModules(array $modules): self
    {
        $this->modules = array_unique($modules);

        return $this;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function setRealDataTypes(bool $realDataTypes): self
    {
        $this->realDataTypes = $realDataTypes;

        return $this;
    }

    public function setActionId($actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }

    public function setRelationType($relationType): self
    {
        $this->relationType = $relationType;

        return $this;
    }

    public function setResourceId($resourceId): self
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    public function setParentIds($parentIds): self
    {
        $this->parentIds = $parentIds;

        return $this;
    }

    public function setParameter($parameter): self
    {
        $this->parameters = $parameter;

        return $this;
    }

    public function setChildIds($childIds): self
    {
        $this->childIds = $childIds;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setListLimit(int $listLimit): self
    {
        $this->listLimit = $listLimit;

        return $this;
    }

    public function setListOffset(int $listOffset): self
    {
        $this->listOffset = $listOffset;

        return $this;
    }

    /**
     * Get the value of relatedEstateId
     */
    public function getRelatedEstateId()
    {
        return $this->relatedEstateId;
    }

    /**
     * Set the value of relatedEstateId
     */
    public function setRelatedEstateId($relatedEstateId): self
    {
        $this->relatedEstateId = $relatedEstateId;

        return $this;
    }

    /**
     * Set the value of relatedSucscriberId
     */
    public function setRelatedSucscriberId($relatedSucscriberId): self
    {
        $this->relatedSubscriberId = $relatedSucscriberId;

        return $this;
    }

    /**
     * Get the value of relatedAddressId
     */
    public function getRelatedAddressId()
    {
        return $this->relatedAddressId;
    }

    /**
     * Set the value of relatedAddressId
     */
    public function setRelatedAddressId($relatedAddressId): self
    {
        $this->relatedAddressId = $relatedAddressId;

        return $this;
    }

    public function setAddressIds(array $addressIds): self
    {
        $this->addressIds = $addressIds;

        return $this;
    }

    public function setAddressId(int $addressId): self
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function setAdvisorId(int $advisorId): self
    {
        $this->advisorId = $advisorId;

        return $this;
    }

    public function setEstateId(int $estateId): self
    {
        $this->estateId = $estateId;

        return $this;
    }

    public function setActionKind(string $actionKind): self
    {
        $this->actionKind = $actionKind;

        return $this;
    }

    public function setActionType(string $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function setEstateIds(array $estateIds): self
    {
        $this->estateIds = $estateIds;

        return $this;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setLabels(bool $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    public function setShowFieldFilters(bool $showFieldFilters): self
    {
        $this->showFieldFilters = $showFieldFilters;

        return $this;
    }

    public function setSortBy(string $sortBy): self
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    public function setShowFieldDependencies(bool $showFieldDependencies): self
    {
        $this->showFieldDependencies = $showFieldDependencies;

        return $this;
    }

    public function setFormatOutput(bool $formatOutput): self
    {
        $this->formatOutput = $formatOutput;

        return $this;
    }

    public function setShowOnlyInactive(bool $showOnlyInactive): self
    {
        $this->showOnlyInactive = $showOnlyInactive;

        return $this;
    }

    public function setFieldList(array $fieldList): self
    {
        $this->fieldList = $fieldList;

        return $this;
    }

    public function setSortOrder(string $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }
}
