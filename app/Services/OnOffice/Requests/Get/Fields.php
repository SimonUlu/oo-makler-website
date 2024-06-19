<?php

namespace App\Services\OnOffice\Requests\Get;

use App\Services\OnOffice\Requests\AbstractRequest;

class Fields extends AbstractRequest
{
    /**
     * Fields constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_GET, 'fields', [
            // "labels" => true,
            // "language" => "DEU",
            // "modules" =>
            // [
            //     "address"
            // ],
        ]);
    }

    public function setLabels(bool $labels): Fields
    {
        $this->parameters['labels'] = $labels;

        return $this;
    }

    public function setRealDataTypes(bool $realDataTypes): Fields
    {
        $this->parameters['realDataTypes'] = $realDataTypes;

        return $this;
    }

    public function setShowFieldMeasureFormat(bool $showFieldMeasureFormat): Fields
    {
        $this->parameters['showFieldMeasureFormat'] = $showFieldMeasureFormat;

        return $this;
    }

    public function setLanguage(string $language): Fields
    {
        $this->parameters['language'] = $language;

        return $this;
    }

    public function setModules(array $modules): Fields
    {
        $this->parameters['modules'] = $modules;

        return $this;
    }

    public function setShowFieldFilters(bool $showFieldFilters): Fields
    {
        $this->parameters['showFieldFilters'] = $showFieldFilters;

        return $this;
    }
}
