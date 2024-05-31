<?php

namespace App\Http\Livewire;

use App\Helpers\Estates\EstateHelper;
use App\Http\Controllers\SessionController;
use App\Services\EstateFilterService;
use App\Services\OnOfficeService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;
use Statamic\Facades\GlobalSet;

class FilterComponent extends Component
{
    protected $queryString = ['filter'];

    public $openModal;

    public $disableLazyLoad = false;

    public $params = [];

    public $sortOptions = [];

    public $all_estates = [];

    public $map_estates = [];

    public $showContactModal;

    public $estateContactModal;

    public $filter = [];

    public $filters = [];

    protected $estates = [];

    public $estateFields = [];

    protected $estateReferences = [];

    protected $listeners = ['loadEstateUser'];

    public $listAppearance;

    public $estateLocations = [];

    public $estateLocationOptions = [];

    public $filterOptions = [];

    public $filterInfo = [];

    public $loadedFilter = true;

    public $perPage = 6;

    public $currentSortField = 'kaufpreis';

    public $currentSortDirection = 'desc';

    public $currentSortText = 'Preis (niedrigster zuerst)';

    protected $estateFilterService;

    protected $onOfficeService;

    use WithPagination;

    public $page = 1;

    // required for view
    public $sort = '';

    public function mount($params, $listAppearance)
    {
        $this->onOfficeService = new onOfficeService();
        $this->params = $params;
        $this->listAppearance = $listAppearance;

        // retrieve standard sort option when mounting
        $this->sortOptions = GlobalSet::find('sortoptions')->in('default')->get('sort_options');
        $standardSortOption = collect($this->sortOptions)
            ->first(function ($option) {
                return $option['isstandard'] === true;
            });

        if ($standardSortOption) {
            $this->currentSortDirection = $standardSortOption['direction'];
            $this->currentSortText = $standardSortOption['option_text'];
            $this->currentSortField = $standardSortOption['onoffice_fieldname'];
        }

        if (request()->session()->has('estateFieldsFull')) {
            $this->estateFields = request()->session()->get('estateFieldsFull');
        } else {
            SessionController::getAllEstateFields(request(), $this->onOfficeService);
            $this->estateFields = request()->session()->get('estateFieldsFull');
        }

        $this->estateLocationOptions = array_map(function ($item) {
            return [
                'value' => $item,
                'label' => $item,
            ];
        }, $this->estateLocations ?? []);

        $this->initFilterOnMount($params);
    }

    public function setSortOption($sortOptionText, $pageSetBack)
    {
        if ($pageSetBack === true) {
            $this->page = 1;
        }
        $this->currentSortText = $sortOptionText;

        $direction = '';

        $onofficeFieldname = '';

        // Lade die Sortieroptionen
        $this->sortOptions = GlobalSet::find('sortoptions')->in('default')->get('sort_options');

        // Finde die entsprechenden Werte für 'onoffice_fieldname' und 'direction'
        foreach ($this->sortOptions as $option) {
            if ($option['option_text'] === $this->currentSortText) {
                // Setze die benötigten Werte
                $onofficeFieldname = $option['onoffice_fieldname'];
                $direction = $option['direction'];
                break; // Stoppe die Schleife, wenn die Übereinstimmung gefunden wurde
            }
        }

        // // Set sort vars to those retrieved from cp
        $this->currentSortField = $onofficeFieldname;
        $this->currentSortDirection = $direction;

        // rerender component
        $this->render();
    }

    public function openModal($estateId)
    {
        $this->openModal = $estateId;
        $this->showContactModal = true;

        $estate_source = GlobalSet::find('estate_appearance_configuration')->in('default')->get('estate_source');

        $this->estates = self::updateEstates($this->filter);

        if ($estate_source == 'database') {
            $estates = $this->estates->items();
            $this->estateContactModal = collect($estates)->where('id', $estateId)->first();
        } else {
            $estates = request()->session()->get('estates');
            $this->estateContactModal = collect($estates)->where('id', $estateId)->first();
        }

        // dd($this->estateContactModal);

        // $this->dispatchBrowserEvent('dataUpdated');
    }

    public function render()
    {
        $this->onOfficeService = new onOfficeService();

        $this->estateFilterService = new EstateFilterService();

        // important leave this before functin call updateEstates otherwise map will be one step behind
        $this->map_estates = $this->estateFilterService->getEstatesForMap($this->filter, 'entry');

        // dd($this->filter);
        $this->estates = self::updateEstates($this->filter);

        // Falls empty nimm reference estates
        if ($this->estates->isEmpty()) {
            $this->estateReferences = self::loadOnOfficeEstates([], 0, 3);
        }

        // dd($this->estates);

        // dd($this->filter);
        $this->estateLocations = $this->estateFilterService->updateEstateLocations($this->estates, 'entry');
        $globalSet = GlobalSet::find('estate_appearance_configuration');

        if ($globalSet) {
            $showMap = $globalSet->inCurrentSite()->get('show_map');
        }
        $estate_type = 'Immobilien';

        if (isset($this->filter['objektart'])) {
            $estate_type = $this->filter['objektart'];
        }

        $this->loadedFilter = ! $this->loadedFilter;

        return view('livewire.filter-component', [
            'filterOptions' => $this->filterOptions,
            'estateLocationOptions' => $this->estateLocationOptions,
            'filterInfo' => EstateHelper::getFilterInfo($this->filters, $this->filterOptions),
            'estates' => $this->estates,
            'estateReferences' => $this->estateReferences,
            'filter' => $this->filter,
            'estateLocations' => $this->estateLocations,
            'estateTypes' => $estate_type,
            'showMap' => $showMap,
            'allEstates' => $this->map_estates,
        ]);
    }

    public function updating($name, $value)
    {
        // Überprüfen, ob die Aktualisierung sich auf den Filter bezieht
        if (strpos($name, 'filter') === 0) {
            // Setzen Sie die Seite auf 1, wenn sich der Filter ändert
            $this->page = 1;
        }
    }

    public function updateEstates($filter = [])
    {

        $estateService = app()->make(EstateFilterService::class);

        $estates = $estateService->updateEstatesWithFilters($this->filter, $this->perPage, $this->currentSortField, $this->currentSortDirection, 'entries', $this->page);

        $this->emit('updateEstateMap', $this->map_estates);
        if ($estates->previousPageUrl() != $estates->currentPage()) {
            $this->dispatchBrowserEvent('dataUpdated');
            $this->filter = $this->addRequestFilters();
        }

        return $estates;
    }

    // function to add request filters of f.e. home-search-form to filter component
    public function addRequestFilters()
    {

        // always set page where pagination is to 1 if filter gets updated
        $this->page = 1;

        $newFilter = request()->input('filter', []);
        $filter = array_merge(
            array_diff_key($this->filter, $newFilter),
            $newFilter
        );

        return $filter;
    }

    public function updateFilterOptionsByEstateType($estates)
    {
        $estateTypes = array_map(function ($item) {
            return $item['elements']['vermarktungsart'];
        }, $estates);

        $estateTypes = array_unique($estateTypes);

        // if estateTypes has only 'kauf',  $filterOptionFields may not include options that are only active for miete
        // if estateTypes has only 'miete', $filterOptionFields may not include options that are only active for kauf
        // if estateTypes has both, $filterOptionFields may include both options
        $filterBuyCase = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('filter_enabled_buy_case')->pluck('onoffice_label_id')->toArray();
        $filterRentCase = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('filter_enabled_rent_case')->pluck('onoffice_label_id')->toArray();
        $kauf = in_array('kauf', $estateTypes);
        $miete = in_array('miete', $estateTypes);

        if ($kauf && ! $miete) {
            return $filterBuyCase;
        }

        if (! $kauf && $miete) {
            return $filterRentCase;
        }

        return array_unique(array_merge($filterBuyCase, $filterRentCase));
    }

    // function to see if pages got rerendered
    // public function has_been_paginated

    public function updatedFilter($value, $key)
    {

        // always set page where pagination is to 1 if filter gets updated
        $this->page = 1;

        // update filter
        $this->filter = request()->input('serverMemo.data.filter');
        // if key is ort, add to merge request and updated filter as query param is only updated after this view has rendered
        $found = false;
        if ($key == 'ort' && isset($value['value']) && isset($this->filter['ort']) && is_array($this->filter['ort'])) {
            if (! in_array($value['value'], $this->filter['ort'])) {
                $this->filter['ort'][] = $value['value'];
                $found = true;
            }
            if ($found == false && in_array($value['value'], $this->filter['ort'])) {
                $this->filter['ort'] = array_filter($this->filter['ort'], function ($item) use ($value) {
                    return $item != $value['value'];
                });
                $found = true;
            }
            if (! $found) {
                $this->filter['ort'] = $value;
            }
        } else {
            $this->filter[$key] = $value;
        }

        $this->filterInfo = EstateHelper::getFilterInfo($this->filter ?? [], $this->filterOptions);

        // update estates
        $this->estates = self::updateEstates($this->filter);

        // if estates is empty, provide alternative estates
        if (empty($this->estates)) {
            $this->estateReferences = self::updateEstates();
        }
        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function resetFilters()
    {
        $this->filter = [
            'vermarktungsart' => [],
        ];

        $this->estates = self::updateEstates($this->filter);
        // if estates is empty, provide alternative estates
        if (empty($this->estates)) {
            $this->estateReferences = self::updateEstates();
        }

        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function removeFilter($filterItem)
    {

        $this->page = 1;

        // unset filter key
        unset($this->filter[$filterItem['key']]);
        // get filter info
        $this->filterInfo = array_filter($this->filterInfo, function ($item) use ($filterItem) {
            return $item['key_raw'] != $filterItem['key'];
        });
        // get estates
        $this->estates = self::updateEstates($this->filter);
        // if estates is empty, provide alternative estates
        if (empty($this->estates)) {
            $this->estateReferences = self::updateEstates();
        }

        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function loadOnOfficeEstates($filter = [], $offset = 0, $limit = 500, $sort = false)
    {
        // get onOffice api service
        $onOfficeService = new OnOfficeService();
        // prepare filter
        $filterValidated = EstateHelper::prepareFilterForOnOfficeApi(request(), $onOfficeService, $filter);
        // get result

        // Manuell paginieren des Ergebnisarrays
        $all_estates = EstateHelper::getEstatesWithImages(request(), $onOfficeService, $filterValidated, 0, $limit, 'DEU', 'estates', 'estateImages'); // $offset, $perPage);

        $currentPage = $this->page ?: 1;
        $offset = ($currentPage - 1) * $this->perPage;

        $items = array_slice($all_estates, $offset, $this->perPage);
        $estates = new LengthAwarePaginator($items, count($all_estates), $this->perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(), // URL für die Pagination-Links
        ]);

        // Überprüfe ob Page changed
        if ($estates->previousPageUrl() != $estates->currentPage()) {
            // Wenn die Seite gewechselt wurde, wird das Browser-Event ausgelöst
            $this->dispatchBrowserEvent('dataUpdated');
            $this->filter = $this->addRequestFilters();
        }

        // dd(SessionController::getAllLocations(request()));
        return $estates;
    }

    public function getSelectOptionsFromLabelId($labelId)
    {
        $options = [];
        $cpValuesIncluded = [];
        $cpValuesExcluded = [];

        $cpValues = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('onoffice_label_id', $labelId)->first() ?? [];

        if (! empty($cpValues)) {
            $cpValuesIncluded = $cpValues['values_included'] ?? [];
            $cpValuesExcluded = $cpValues['values_excluded'] ?? [];
        }

        if (array_key_exists($labelId, $this->estateFields)) {
            array_map(function ($item) use (&$options, $cpValuesIncluded, $cpValuesExcluded) {
                // include values
                if (! empty($cpValuesIncluded) && ! in_array($item, $cpValuesIncluded)) {
                    return;
                }
                // exclude values
                if (! empty($cpValuesExcluded) && in_array($item, $cpValuesExcluded)) {
                    return;
                }
                // add to option
                $options[] = [
                    'value' => $item,
                    'label' => $item,
                ];
            }, $this->estateFields[$labelId]['permittedvalues']);
        }

        return $options;
    }

    private function initFilterOnMount($params)
    {

        $filterOptionFields = SessionController::getFilterOptionFields();

        $this->filterOptions = SessionController::fillFilterOptions(request(), $this->onOfficeService, $filterOptionFields);

        $this->filterInfo = EstateHelper::getFilterInfo($this->filter, $this->filterOptions);
        foreach ($this->filterOptions as $key => $value) {
            if (! isset($this->filter[$key])) {
                $this->filter[$key] = '';
            }
        }

        // give filter request params
        if (isset($params['filter']) && is_array($params['filter'])) {
            foreach ($params['filter'] as $key => $value) {
                // Überprüfe, ob der Schlüssel im $this->filter existiert
                if (array_key_exists($key, $this->filter)) {
                    // Weise den Wert direkt zu, ohne Konvertierung
                    $this->filter[$key] = $value;
                }
            }
        }
    }
}
