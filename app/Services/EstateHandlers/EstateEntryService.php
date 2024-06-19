<?php

namespace App\Services\EstateHandlers;

use App\Contracts\EstateServiceInterface;
use App\Helpers\Estates\EstateEntry;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Statamic\Facades\Entry;

class EstateEntryService implements EstateServiceInterface
{
    public static function getAllEstates()
    {
        return \Statamic\Facades\Collection::find('estate_entries')->queryEntries()->get();
    }

    public static function getEstateEntry($entryId)
    {
        $entry = \Statamic\Facades\Collection::find('estate_entries')->queryEntries()->where('id_internal', $entryId)->first();

        // send entry through pipeline
        return app(Pipeline::class)
            ->send($entry)
            ->through([
                new \App\Pipes\EntryFormatFields(),
            ])
            ->thenReturn();
    }

    public static function getFilteredEstates(string $collectionName, array $filter, int $perPage = 10, string $sortField = 'kaufpreis', string $sortDirection = 'asc', int $page = 1, $randomize = false): LengthAwarePaginator
    {
        // Fetch the estates from the collection
        $estates = \Statamic\Facades\Collection::find($collectionName)->queryEntries()->get();

        // Apply the pipeline filters and sorting
        $estates = app(Pipeline::class)
            ->send($estates)
            ->through([
                new \App\Pipes\EntryFormatFields(),
                new \App\Pipes\EntryFilterEstates($filter),
                new \App\Pipes\EntrySortEstates($sortField, $sortDirection),
            ])
            ->thenReturn();

        // Randomize the estates if $randomize is true
        if ($randomize) {
            $estates = $estates->shuffle();
        }

        // Paginate the estates
        return new LengthAwarePaginator(
            $estates->forPage($page, $perPage),
            $estates->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }

    public static function getEstatesForMap(array $filter): Collection
    {
        $entries = Entry::query()->where('collection', 'estate_entries')->get();

        $estates = $entries->map(function ($entry) {
            $data = $entry->toArray();

            return (new EstateEntry($data))->toArray();
        });

        return app(Pipeline::class)
            ->send($estates)
            ->through([
                new \App\Pipes\EntryFormatFields(),
                new \App\Pipes\EntryFilterEstates($filter),
            ])
            ->thenReturn();
    }

    public static function getLocationsOfAllEstates(): array
    {
        $entries = \Statamic\Facades\Collection::find('estate_entries')->queryEntries()->get();

        return $entries->pluck('ort')->filter()->unique()->values()->all();
    }

    public static function getEstatesUnpaginated(array $filter, int $perPage = 15, string $sortField = 'kaufpreis', string $sortDirection = 'asc', string $collectionName = 'estate_entries', int $limit = 1000): Collection
    {
        $entries = Entry::query()->where('collection', $collectionName)->get();

        $filteredEntries = app(Pipeline::class)
            ->send($entries)
            ->through([
                new \App\Pipes\EntryFormatFields(),
                new \App\Pipes\EntryFilterEstates($filter),
                new \App\Pipes\EntrySortEstates($sortField, $sortDirection),
            ])
            ->thenReturn();

        // Apply the limit after filtering and sorting
        return $filteredEntries->take($limit);
    }

    /**
     * Get the first filtered entry with enabled filters by the specified filter name.
     */
    public static function getFilteredEntry(array $filters, string $filterName): ?array
    {
        // Filter the collection to find the item with the matching filterName
        $filteredCollection = collect($filters)->filter(function ($item) use ($filterName) {
            return $item['home_view_model_filter_name'] === $filterName;
        });

        // Get the first item from the filtered collection
        $filter = $filteredCollection->first();

        // If no filter is found or replicator_field_filter is empty, return null
        if (empty($filter) || empty($filter['replicator_field_filter'])) {
            return null;
        }

        // Remove filters that are not enabled
        $filter['replicator_field_filter'] = array_filter($filter['replicator_field_filter'], function ($replicatorFilter) {
            return $replicatorFilter['enabled'];
        });

        $filter['replicator_field_filter'] = array_values($filter['replicator_field_filter']);

        return $filter;
    }
}
