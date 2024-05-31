<?php

namespace App\Services\EstateHandlers;

use App\Contracts\EstateServiceInterface;
use App\Helpers\Estates\EstateEntry;
use App\Jobs\ImportEstateDataForEntries;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Statamic\Facades\Entry;

class EstateEntryService implements EstateServiceInterface
{
    public function getEstatesForMap(array $filter): Collection
    {
        $entries = Entry::query()->where('collection', 'estate_entries')->get();

        $estates = $entries->map(function ($entry) {
            $data = $entry->toArray();

            return (new EstateEntry($data))->toArray();
        });

        $estates = app(Pipeline::class)
            ->send($estates)
            ->through([
                new \App\Pipes\EntryFilterEstates($filter),
            ])
            ->thenReturn();

        return $estates;
    }

    public function getEstatesWithImages(array $filter, int $perPage = 10, string $sortField = 'kaufpreis', string $sortDirection = 'asc', int $page = 1): LengthAwarePaginator
    {
        $entries = Entry::query()->where('collection', 'estate_entries')->get();

        $estates = $entries->map(function ($entry) {
            $data = $entry->toArray();

            return (new EstateEntry($data))->toArray();
        });

        $estates = app(Pipeline::class)
            ->send($estates)
            ->through([
                new \App\Pipes\EntryFilterEstates($filter),
                new \App\Pipes\EntrySortEstates($sortField, $sortDirection),
            ])
            ->thenReturn();

        $paginatedEstates = new LengthAwarePaginator(
            $estates->forPage($page, $perPage),
            $estates->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return $paginatedEstates;
    }

    public static function getLocationsOfAllEstates(): array
    {
        $entries = Entry::query()->where('collection', 'estate_entries')->get();

        $estates = $entries->map(function ($entry) {
            $data = $entry->toArray();

            return (new EstateEntry($data))->toArray();
        });

        $locations = [];

        foreach ($estates as $estate) {
            if (isset($estate['elements']) && isset($estate['elements']['ort'])) {
                $locations[] = $estate['elements']['ort'];
            }
        }

        return array_values(array_unique($locations));
    }

    public static function getEstatesUnpaginated(array $filter, int $perPage = 15, string $sortField = 'kaufpreis', string $sortDirection = 'asc', string $collectionName = 'estate_entries'): Collection
    {
        $entries = Entry::query()->where('collection', $collectionName)->limit($perPage)->get();

        if ($entries->isEmpty()) {
            ImportEstateDataForEntries::dispatch();
        }

        $estates = $entries->map(function ($entry) {
            $data = $entry->toArray();

            return (new EstateEntry($data))->toArray();
        });

        // dd($filter);

        return app(Pipeline::class)
            ->send($estates)
            ->through([
                new \App\Pipes\EntryFilterEstates($filter),
                new \App\Pipes\EntrySortEstates($sortField, $sortDirection),
            ])
            ->thenReturn();
    }
}
