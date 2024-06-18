<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class EstatePicture extends AbstractRequest
{
    /**
     * Estates constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_GET, 'estatepictures');

        $this->setData();
    }

    public function setEstateIds(array $estateIds): EstatePicture
    {
        $this->parameters['estateids'] = $estateIds;

        return $this;
    }

    private function setData(): void
    {
        $data = [
            'categories' => [
                'Titelbild',
                'Foto',
                'Foto_gross',
                'Panorama',
                'Grundriss',
                'Lageplan',
                'Epass_Skala',
                'Energiepass-Skala',
            ],
            'size' => 'original',
            'language' => 'DEU',
        ];
        $this->parameters = $data;

    }

    public function setCategories($categories): void
    {
        $this->parameters['categories'] = $categories;
    }
}
