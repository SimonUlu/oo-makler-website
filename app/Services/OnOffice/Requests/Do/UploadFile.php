<?php

namespace App\Services\OnOffice\Requests\Do;

use App\Services\OnOffice\Requests\AbstractRequest;

class UploadFile extends AbstractRequest
{
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_DO, 'uploadfile');
    }

    public function setFileData(string $file, string $data): UploadFile
    {
        $this->parameters['file'] = $file;
        $this->parameters['data'] = $data;

        return $this;
    }

    public function setModuleData(
        string $tmpUploadId,
        string $file,
        string $title,
        string $art,
        int $relatedRecordId,
        string $module = 'estate'
    ): UploadFile {
        $this->parameters['module'] = $module;
        $this->parameters['tmpUploadId'] = $tmpUploadId;
        $this->parameters['file'] = $file;
        $this->parameters['title'] = $title;
        $this->parameters['Art'] = $art;
        $this->parameters['relatedRecordId'] = $relatedRecordId;
        $this->parameters['setDefaultPublicationRights'] = true;

        return $this;
    }
}
