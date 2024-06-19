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
        $collectionName = 'estate_entries';
        // check if there is a filter active
        $homeViewModelFilters = GlobalSet::find('onoffice')->in('default')->get('home_view_model_filter');
        // Filter the collection to find the entry with the specific "home_view_model_filter_name"
        $filteredEntryBuy = collect($homeViewModelFilters)->first(function ($item) {
            return $item['home_view_model_filter_name'] === 'home';
        });
        // get filters
        $filtersBuy = OnOfficeService::transformFilterArray($filteredEntryBuy);
        $estatesBuy = EstateEntryService::getEstatesUnpaginated($filtersBuy, 3, 'kaufpreis', 'desc', $collectionName);

        $filteredEntrySell = collect($homeViewModelFilters)->first(function ($item) {
            return $item['home_view_model_filter_name'] === 'verkaufen';
        });
        $filtersSell = OnOfficeService::transformFilterArray($filteredEntrySell);
        $estatesSell = EstateEntryService::getEstatesUnpaginated($filtersSell, 3, 'kaufpreis', 'desc', 'estate_entries_full', 30);
        $estatesSell = OnOfficeService::removeFieldsFromEstate($estatesSell);

        $estateLocations = EstateEntryService::getLocationsOfAllEstates();
        $estateListAppearance = GlobalSet::find('estate_appearance_configuration')->in('default')->get('listappearance');

        return [
            'estates' => $estatesBuy,
            'estateReferences' => $estatesSell,
            'estateFields' => EstateHelper::getEstateFields(),
            'collectionName' => $collectionName,
            'estateLocations' => json_encode($estateLocations),
            'listAppearance' => $estateListAppearance ?? 'list',
        ];
    }
}
