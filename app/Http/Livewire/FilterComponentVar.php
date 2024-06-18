<?php

namespace App\Http\Livewire;

use App\Helpers\Estates\EstateHelper;
use App\Helpers\Filters\SortOption;
use App\Http\Controllers\SessionController;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Livewire\Component;
use Livewire\WithPagination;
use Statamic\Facades\Collection;
use Statamic\Facades\GlobalSet;

class FilterComponentVar extends Component
{
    use WithPagination;

    public $openModal;

    public $params = [];

    public $sortOptions = [];

    public $allEstates;

    public $showContactModal;

    public $estateContactModal;

    public $filter = [];

    public $filters = [];

    public $estateFields = [];

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

    public $page = 1;

    public $sort = '';

    public $collectionName;

    private $filter_hidden;

    public $isRadiusFilterActive = false;

    public $radiusZipCode;

    public $sliderValue;

    public $estates;

    public $isLoading = false;

    protected $queryString = ['filter'];

    protected $listeners = ['loadEstateUser'];

    public function mount($collectionName): void
    {
        $this->collectionName = $collectionName;
        $this->listAppearance = GlobalSet::find('estate_appearance_configuration')->in('default')->get('listappearance') ?? 'list';
        $this->estateLocations = EstateEntryService::getLocationsOfAllEstates();
        $this->allEstates = OnOfficeService::removeFieldsFromEstate(Collection::find($this->collectionName)->queryEntries()->get());

        $this->initializeEstateFields();
        $this->initializeSortOptions();
        $this->initializeFilterOptions();
        $this->initFilterOnMount();

        // Initial update on mount
        $this->updateEstates();
    }

    private function initializeSortOptions(): void
    {
        $cpSortOptions = GlobalSet::find('sortoptions')->in('default')->get('sort_options');
        $this->sortOptions = collect($cpSortOptions)->map(function ($cpSortOption) {
            $sortOption = new SortOption(
                $cpSortOption['direction'],
                $cpSortOption['onoffice_fieldname'],
                $cpSortOption['isstandard'],
                $cpSortOption['option_text'],
                $cpSortOption['id']
            );

            if ($cpSortOption['show_kauf'] && $cpSortOption['show_miete']) {
                $sortOption->setType('All');
            } elseif ($cpSortOption['show_kauf']) {
                $sortOption->setType('Kauf');
            } elseif ($cpSortOption['show_miete']) {
                $sortOption->setType('Miete');
            }

            return $sortOption->shouldDisplay($this->filter) ? $sortOption : null;
        })->filter()->values()->all();

        $standardSortOption = collect($this->sortOptions)->firstWhere('isStandardOption', true) ?? $this->sortOptions[0] ?? null;

        if ($standardSortOption) {
            $this->currentSortDirection = $standardSortOption->direction;
            $this->currentSortText = $standardSortOption->optionText;
            $this->currentSortField = $standardSortOption->onOfficeField;
        }
    }

    private function initializeEstateFields(): void
    {
        if (! request()->session()->has('estateFieldsFull')) {
            SessionController::getAllEstateFields();
        }
        $this->estateFields = request()->session()->get('estateFieldsFull');
    }

    private function initializeFilterOptions(): void
    {
        $this->estateLocationOptions = array_map(function ($item) {
            return ['value' => $item, 'label' => $item];
        }, $this->estateLocations ?? []);
    }

    public function setSortOption($sortOptionText, $pageSetBack): void
    {
        if ($pageSetBack) {
            $this->page = 1;
        }
        $this->currentSortText = $sortOptionText;

        $sortOption = collect($this->sortOptions)->firstWhere('optionText', $sortOptionText);

        if ($sortOption) {
            $this->currentSortField = $sortOption['onOfficeField'];
            $this->currentSortDirection = $sortOption['direction'];
        }

        $this->updateEstates();
    }

    public function openModal($estateId): void
    {
        $this->openModal = $estateId;
        $this->showContactModal = true;

        $this->updateEstates();

        $estates = request()->session()->get('estates');
        $this->estateContactModal = collect($estates)->firstWhere('id', $estateId);
    }

    public function render(): \Illuminate\View\View
    {
        // Ensure estatesPaginator is not null
        $estatesPaginator = new LengthAwarePaginator(
            $this->estates->forPage($this->page, $this->perPage),
            $this->estates->count(),
            $this->perPage,
            $this->page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        $this->estateLocations = EstateEntryService::getLocationsOfAllEstates();

        $globalSet = GlobalSet::find('estate_appearance_configuration');
        $showMap = $globalSet?->inCurrentSite()->get('show_map');
        $estate_type = $this->filter['objektart'] ?? 'Immobilien';

        if ($estatesPaginator->isEmpty()) {
            $estateRecommendation = $this->getRecommendationEstates($this->filter, 0, 3);
        }

        $this->loadedFilter = ! $this->loadedFilter;

        $this->isLoading = false;

        return view('livewire.filter-component-var', data: [
            'filterOptions' => $this->filterOptions,
            'estateLocationOptions' => $this->estateLocationOptions,
            'filterInfo' => EstateHelper::getFilterInfo($this->filters, $this->filterOptions),
            'estates' => $this->estates,
            'estatesPaginator' => $estatesPaginator,
            'estateRecommendation' => $estateRecommendation ?? [],
            'filter' => $this->filter,
            'radiusZipCode' => $this->radiusZipCode,
            'sliderValue' => $this->sliderValue,
            'estateLocations' => $this->estateLocations,
            'estateFields' => $this->estateFields,
            'estateTypes' => $estate_type,
            'showMap' => $showMap ?? false,
            'allEstates' => $this->allEstates,
            'sortOptions' => $this->sortOptions,
        ]);
    }

    public function updating($name, $value): void
    {
        if (str_starts_with($name, 'filter')) {
            $this->page = 1;
        }
    }

    public function updateMap($estates): void
    {
        $this->emit('updateEstateMap', $estates);
    }

    public function updateEstates(): void
    {
        $filter = EstateHelper::convertFilter(request(), $this->filter);

        $this->estates = self::getCurrentEstates($filter);

        // Emit the event with the updated estates data
        $this->updateMap($this->estates);
    }

    public function getCurrentEstates($filter)
    {
        return app(Pipeline::class)
            ->send($this->allEstates)
            ->through([
                new \App\Pipes\EntryFormatFields(),
                new \App\Pipes\EntryFilterEstates($filter),
                new \App\Pipes\EntrySortEstates($this->currentSortField, $this->currentSortDirection),
            ])
            ->thenReturn();
    }

    public function addRequestFilters(): array
    {
        $this->page = 1;
        $newFilter = request()->input('filter', []);

        if (! isset($this->filter)) {
            return $newFilter;
        }

        return array_merge(array_diff_key($this->filter, $newFilter), $newFilter);
    }

    public function updatedFilter($value, $key): void
    {
        $this->isLoading = true;

        $this->page = 1;

        // Check if the filter key is one that requires conversion
        if (str_ends_with($key, '__von') || str_ends_with($key, '__bis')) {
            $this->filter[$key] = $this->convertToFloat($value);
        } else {
            if ($key == 'ort' && isset($value['value']) && isset($this->filter['ort']) && is_array($this->filter['ort'])) {
                if (! in_array($value['value'], $this->filter['ort'])) {
                    $this->filter['ort'][] = $value['value'];
                } else {
                    $this->filter['ort'] = array_filter($this->filter['ort'], fn ($item) => $item != $value['value']);
                }
            } else {
                $this->filter[$key] = $value;
            }
        }

        $this->filterInfo = EstateHelper::getFilterInfo($this->filter ?? [], $this->filterOptions);
        $this->updateEstates();

        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function resetFilter(): void
    {
        $this->filter = ['vermarktungsart' => []];
        $this->updateEstates();

        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function removeFilter($filterKey): void
    {
        $this->page = 1;
        unset($this->filter[$filterKey]);
        $this->filterInfo = array_filter($this->filterInfo, fn ($item) => $item['key_raw'] != $filterKey);
        $this->updateEstates();

        $this->dispatchBrowserEvent('dataUpdated');
    }

    public function convertToFloat($value): float
    {
        // Remove the Euro symbol and spaces
        $value = str_replace(['€', ' '], '', $value);

        // Replace comma with dot for decimal separation
        $value = str_replace(',', '.', $value);

        // Remove any dots used as thousand separators
        $value = str_replace('.', '', substr($value, 0, -3)).substr($value, -3);

        // Convert to float
        return (float) $value;
    }

    public function getRecommendationEstates($filter = [], $offset = 0, $limit = 3, $sort = false): LengthAwarePaginator
    {
        // get vermarktungsart from filter if is set
        $filterForRecommendations['vermarktungsart'] = $filter['vermarktungsart'] ?? [];

        return EstateEntryService::getFilteredEstates($this->collectionName, $filterForRecommendations, $limit, 'kaufpreis', 'desc', 1);
    }

    public function clearFilter($filterKey): void
    {
        // Clear the filter value
        unset($this->filter[$filterKey]);

        // Optionally, clear the hidden filter value if you have one
        unset($this->filter_hidden[$filterKey]);

        // Update estates and reload the page
        $this->updateEstates();
    }

    public function getSelectOptionsFromLabelId($labelId): array
    {
        $options = [];
        $cpValues = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->firstWhere('onoffice_label_id', $labelId) ?? [];
        $cpValuesIncluded = $cpValues['values_included'] ?? [];
        $cpValuesExcluded = $cpValues['values_excluded'] ?? [];

        if (array_key_exists($labelId, $this->estateFields)) {
            foreach ($this->estateFields[$labelId]['permittedvalues'] as $item) {
                if ((! empty($cpValuesIncluded) && ! in_array($item, $cpValuesIncluded)) ||
                    (! empty($cpValuesExcluded) && in_array($item, $cpValuesExcluded))) {
                    continue;
                }
                $options[] = ['value' => $item, 'label' => $item];
            }
        }

        return $options;
    }

    private function initFilterOnMount(): void
    {
        if (! isset($this->filter['radius'])) {
            $this->filter['radius'] = '';
        } else {
            $this->sliderValue = $this->filter['radius'];
        }

        if (! isset($this->filter['radiusZipCode'])) {
            $this->filter['radiusZipCode'] = '';
        } else {
            $this->radiusZipCode = $this->filter['radiusZipCode'];
        }

        $filterOptionFields = SessionController::getFilterOptionFields();
        $this->filterOptions = SessionController::fillFilterOptions($filterOptionFields);
        $this->filterInfo = EstateHelper::getFilterInfo($this->filter, $this->filterOptions);

        $this->isRadiusFilterActive = GlobalSet::find('estate_filter_configuration')->in('default')->get('estate_search_by_radius') == 'yes' ?? false;

        foreach ($this->filterOptions as $key => $value) {
            $this->filter[$key] = $this->filter[$key] ?? '';
        }

        if (isset($this->filter) && is_array($this->filter)) {
            foreach ($this->filter as $key => $value) {
                if (array_key_exists($key, $this->filter)) {
                    $this->filter[$key] = $value;
                }
            }
        }
    }
}
