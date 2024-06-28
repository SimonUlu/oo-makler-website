<?php

namespace App\ViewModels;

use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Statamic\Facades\GlobalSet;
use Statamic\View\ViewModel;

class KaufenViewModel extends ViewModel
{
    public function data(): array
    {

        $collectionName = 'estate_entries';

        $homeViewModelFilters = GlobalSet::find('onoffice')->in('default')->get('home_view_model_filter');
        // Filter the collection to find the entry with the specific "home_view_model_filter_name"
        $filteredEntryBuy = EstateEntryService::getFilteredEntry($homeViewModelFilters, 'home');

        // get filters
        $filtersBuy = OnOfficeService::transformFilterArray($filteredEntryBuy);
        $estatesBuy = EstateEntryService::getEstatesUnpaginated($filtersBuy, 3, 'erstellt_am', 'desc', $collectionName);

        return [
            'estates' => $estatesBuy,
            'estateFields' => EstateHelper::getEstateFields(),
        ];
    }
}
