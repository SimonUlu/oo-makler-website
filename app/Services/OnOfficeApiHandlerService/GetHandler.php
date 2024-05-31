<?php

namespace App\Services\OnOfficeApiHandlerService;

use App\Exceptions\OnOfficeApiReadException;
use App\Services\OnOfficeApiService\Api;
use App\Services\OnOfficeApiService\OnOfficeQueryBuilderGet;
use Illuminate\Support\Facades\Log;

class GetHandler
{
    public Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    // public function getFieldConfiguration(string $module, array $fieldList = [], bool $labels = true, string $language = 'DEU', bool $showFieldFilters = false, bool $showFieldDependencies = false, bool $showOnlyInactive = false, bool $realDataTypes = true, bool $showFieldMeasureFormat = true): array
    // {
    //     $queryBuilder = new OnOfficeQueryBuilderGet('fields');

    //     $queryBuilder
    //         ->setField('fields')
    //         ->setModules([$module])
    //         ->setLanguage($language)
    //         ->setLabels($labels)
    //         ->setShowFieldFilters($showFieldFilters)
    //         ->setShowFieldDependencies($showFieldDependencies)
    //         ->setShowOnlyInactive($showOnlyInactive)
    //         ->setRealDataTypes($realDataTypes)
    //         ->setShowFieldMeasureFormat($showFieldMeasureFormat);

    //     if ($fieldList !== []) {
    //         $queryBuilder->setFieldList($fieldList);
    //     }

    //     $queryBuilder
    //         ->render();

    //     return $this->handleSend($queryBuilder, 'der Felder')['data']['records'][0]['elements'] ?? [];
    // }

    public function getFieldConfiguration(string $module): array
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('fields');

        $queryBuilder
            ->setField('fields')
            ->setModules([$module])
            ->setRealDataTypes(true)
            ->setShowFieldDependencies(true)
            ->setLabels(true)
            ->setFormatOutput(true)
            ->setShowFieldMeasureFormat(true)
            ->setListLimit(500);

        $queryBuilder
            ->render();

        // dd($queryBuilder);

        return $this->handleSend($queryBuilder, 'der Felder');
    }

    public function users()
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('users');

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'der User');
    }

    public function relations(string $relationsType, array $parentIds)
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('idsfromrelation');

        $queryBuilder
            ->setRelationType($relationsType)
            ->setParentIds($parentIds);

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, '');
    }

    public function getActionKindTypes()
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('user');

        $data = [
            'lang' => 'ENG',
        ];

        $queryBuilder
            ->setData($data)
            ->setResourceType('actionkindtypes');

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'der ActionKindTypes');
    }

    public function getImagesFromEstates(array $estateIds, array $categories = ['Titelbild', 'Foto', 'Foto_gross', 'Panorama', 'Grundriss'], $language = 'DEU'): array
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('estatepictures');
        $queryBuilder
            ->setEstateIds($estateIds)
            ->setCategories($categories)
            ->setLanguage($language);

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Image');
    }

    public function getTitleImageFromEstate(array $estateIds): array
    {
        $queryBuilder = new OnOfficeQueryBuilderGet('estatepictures');

        $queryBuilder
            ->setEstateIds($estateIds)
            ->setCategories(['Titelbild'])
            ->setLanguage('DEU');

        $queryBuilder
            ->render();

        return $this->handleSend($queryBuilder, 'des Image');
    }

    /**
     * returns all user with id and name
     */
    public function handleSend(OnOfficeQueryBuilderGet $queryBuilder, string $module): array
    {
        $response = $this->api->send($queryBuilder);

        if (isset($response['error']) && ! empty($response['error'] && $response['status_code'] === true)) {
            $message = ' Fehler: '.$response['status']['message'];

            return [];
        }

        if (! empty($response['status']['errorcode'])) {
            $message = ' Fehler: '.$response['status']['message'];

            $message = ' Fehler: '.$response['response']['results'][0]['status']['message'];
            Log::error($response);
            throw new OnOfficeApiReadException($message);
        }

        return $response['response']['results'][0] ?? [];
    }
}
