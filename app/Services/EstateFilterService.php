<?php

namespace App\Services;

use App\Services\EstateHandlers\EstateEntryService;
use App\Services\EstateHandlers\EstateService;
use Statamic\Facades\GlobalSet;

class EstateFilterService
{
    protected $service;

    public function __construct() {}

    protected function getService($type)
    {
        if ($type == 'database') {
            return new EstateService();
        } else {
            return new EstateEntryService();
        }
    }

    public function updateEstateLocations($estates, $type)
    {
        $this->service = $this->getService($type);

        $estates = $this->service->getLocationsOfAllEstates();

        return $estates;
    }

    public function updateEstatesWithFilters($filter, $perPage, $sortField, $sortDirection, $type, $page = 1)
    {
        $this->service = $this->getService($type);

        if (GlobalSet::find('estate_appearance_configuration')->in('default')->get('pagination')) {
            $perPage = GlobalSet::find('estate_appearance_configuration')->in('default')->get('pagination');
        }

        $estates = $this->service->getEstatesWithImages($filter, $perPage, $sortField, $sortDirection, $page);

        // dd(SessionController::getAllLocations(request()));
        return $estates;
    }

    public function getEstatesForMap($filter, $type)
    {
        $this->service = $this->getService($type);
        $estates = $this->service->getEstatesForMap($filter);

        return $estates;
    }
}
