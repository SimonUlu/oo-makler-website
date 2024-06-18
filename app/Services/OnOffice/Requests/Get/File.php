<?php

namespace App\Services\OnOffice\Requests\Get;

use App\Services\OnOffice\Requests\AbstractRequest;

class File extends AbstractRequest
{
    /**
     * File constructor.
     */
    public function __construct($resourceId)
    {
        parent::__construct(self::ACTION_ID_GET, 'file', [
            // "labels" => true,
            // "language" => "DEU",
            // "modules" =>
            // [
            //     "address"
            // ],
        ]);

        $this->setResourceId($resourceId);
    }

    public function setDocumentAttribute(string $documentAttribute): File
    {
        $this->parameters['documentAttribute'] = $documentAttribute;

        return $this;
    }

    public function setShowIsPublishedOnHomepage(bool $showIsPublishedOnHomepage): File
    {
        $this->parameters['showIsPublishedOnHomepage'] = $showIsPublishedOnHomepage;

        return $this;
    }

    public function setEstateId(string $estateId): File
    {
        $this->parameters['estateid'] = $estateId;

        return $this;
    }

    public function setListLimit(int $listLimit): File
    {
        $this->parameters['listlimit'] = $listLimit;

        return $this;
    }
}
