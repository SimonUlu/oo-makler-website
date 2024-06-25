<?php

namespace App\ViewModels;

use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Statamic\Facades\GlobalSet;
use Statamic\View\ViewModel;

class VerkaufenViewModel extends ViewModel
{
    public function data(): array
    {
        // check if there is a filter active
        $homeViewModelFilters = GlobalSet::find('onoffice')->in('default')->get('home_view_model_filter');
        // Filter the collection to find the entry with the specific "home_view_model_filter_name"
        $filteredEntry = EstateEntryService::getFilteredEntry($homeViewModelFilters, 'verkaufen');
        $filters = OnOfficeService::transformFilterArray($filteredEntry);
        $estates = EstateEntryService::getEstatesUnpaginated($filters, 3, 'kaufpreis', 'desc', 'estate_entries_references', 30);
        $estates = OnOfficeService::removeFieldsFromEstate($estates);

        return [
            'estateReferences' => $estates,
            'estateFields' => EstateHelper::getEstateFields(),
        ];
    }
}
