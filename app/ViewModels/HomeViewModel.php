<?php

namespace App\ViewModels;

use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Statamic\Facades\GlobalSet;
use Statamic\View\ViewModel;

class HomeViewModel extends ViewModel
{
    public function data(): array
    {
        $onOfficeService = new OnOfficeService();
        // check if there is a filter active
        $homeViewModelFilters = GlobalSet::find('onoffice')->in('default')->get('home_view_model_filter');

        // Filter the collection to find the entry with the specific "home_view_model_filter_name"
        $filteredEntry = collect($homeViewModelFilters)->first(function ($item) {
            return $item['home_view_model_filter_name'] === 'home';
        });
        $filters = $onOfficeService->transformFilterArray($filteredEntry);
        // get immoglobals from cp globals
        // $filterEstateReferencesRaw = EstateHelper::getFilterEstateReferences();
        // get estateReferences
        $estateEntryService = new EstateEntryService();

        $estates = $estateEntryService->getEstatesUnpaginated($filters, 3, 'kaufpreis', 'desc');

        $estateReferences = $estateEntryService->getEstatesUnpaginated(
            [],
            9,
            'erstellt_am',
            'desc',
            'estate_entries_references'
        );

        // $estateReferences = EstateHelper::getEstatesWithImages(request(), $onOfficeService, EstateHelper::prepareFilterForOnOfficeApi(request(), $onOfficeService, $filterEstateReferencesRaw), 0, 500, 'estateReferences', 'estateReferenceImages');
        // get estateLocations
        // $estateLocations = EstateHelper::getLocations('ort', $estates);
        $estateLocations = EstateEntryService::getLocationsOfAllEstates();
        $estateListAppearance = GlobalSet::find('estate_appearance_configuration')->in('default')->get('listappearance');

        return [
            'estates' => $estates,
            'estateLocations' => json_encode($estateLocations),
            // 'estateReferences' => $estateReferences,
            'listAppearance' => $estateListAppearance ?? 'list',
            'estateReferences' => $estateReferences,
        ];
    }
}
