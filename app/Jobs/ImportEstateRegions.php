<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class ImportEstateRegions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->queue = 'sync-onoffice';
    }

    /**
     * Execute the job.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): void
    {
        // Retrieve the global set
        $globalSet = GlobalSet::find('onoffice')->in('default');

        $apiConnection = [
            'token' => $globalSet->get('onoffice_token'),
            'secret' => $globalSet->get('onoffice_secret'),
        ];

        $entries = self::getOnOfficeEstateRegions($apiConnection);

        if (empty($entries)) {
            return;
        }

        // get existing entries in this collection
        $collectionName = 'estate_regions';

        // delete all entries that exist in the collection
        $existingEntries = Entry::query()->where('collection', $collectionName)->get();
        // delete entries
        foreach ($existingEntries as $entry) {
            try {
                $entry->delete();
            } catch (Exception $e) {
                Log::error("Failed to delete entry with id_internal {$entry->get('id_internal')}: {$e->getMessage()}");
            }
        }

        $regions = array_keys(collect($entries)->first());
        // create the new entries
        foreach ($entries as $entry) {
            self::createEntry($entry, $regions, $collectionName);
        }
    }

    /**
     * Get the data from the OnOffice API
     */
    public static function getOnOfficeEstateRegions(array $apiConnection): array
    {
        // get api handler
        $apiHandler = new \App\Services\OnOffice\Connectors\EstateConnector();

        // get total records count
        return $apiHandler
            ->setConnector($apiConnection)
            ->getOnOfficeRegions();
    }

    public function getEntryData($entry, $fields): array
    {
        $entryData = [];

        foreach ($fields as $fieldName) {
            $entryData[$fieldName] = $entry[$fieldName] ?? null;
        }

        // Encode complex fields as JSON
        $entryData['children'] = json_encode($entryData['children']);
        $entryData['postalcodes'] = json_encode($entryData['postalcodes']);

        $entryData['title'] = htmlspecialchars(trim($entryData['name']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_title'] = htmlspecialchars(trim($entry['name']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_description'] = htmlspecialchars(trim($entry['description']), ENT_QUOTES, 'UTF-8');
        $entryData['slug'] = Str::slug($entry['id_internal']);

        unset($entryData['id']);

        return $entryData;
    }

    public function createEntry($entry, $fields, string $collectionName): void
    {

        $collection = Collection::findByHandle($collectionName);

        if (! $collection) {
            Log::error("Collection '$collectionName' not found.");

            return;
        }

        $entryData = self::getEntryData($entry, $fields);
        $entryCreated = Entry::make()
            ->collection($collection->handle())
            ->blueprint($collection->entryBlueprint())
            ->slug($entryData['slug'])
            ->data($entryData);

        try {
            $entryCreated->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

    }
}
