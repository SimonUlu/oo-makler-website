<?php

namespace App\Jobs;

use Exception;
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

class ImportEstateFields implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
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

        $entries = self::getOnOfficeEstateFields($apiConnection);

        if (empty($entries)) {
            return;
        }

        // get existing entries in this collection
        $collectionName = 'estate_fields';

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

        $fields = array_keys(collect($entries)->first());
        // create the new entries
        foreach ($entries as $entry) {
            self::createEntry($entry, $fields, $collectionName);
        }
    }

    /**
     * Get the data from the OnOffice API
     */
    public static function getOnOfficeEstateFields(array $apiConnection): array
    {
        // get api handler
        $apiHandler = new \App\Services\OnOffice\Connectors\EstateConnector();

        // get total records count
        return $apiHandler
            ->setConnector($apiConnection)
            ->getOnOfficeFields();
    }

    public function getEntryData($entry, $fields): array
    {
        $entryData = [];

        foreach ($fields as $fieldName) {
            $entryData[$fieldName] = $entry[$fieldName] ?? null;
        }

        // Encode complex fields as JSON
        $entryData['title'] = htmlspecialchars(trim($entryData['label']), ENT_QUOTES, 'UTF-8');
        $entryData['length_field'] = htmlspecialchars(trim($entryData['length']), ENT_QUOTES, 'UTF-8');
        $entryData['compound_fields'] = json_encode($entryData['compoundFields'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
        $entryData['id_internal'] = htmlspecialchars(trim($entry['label_id']), ENT_QUOTES, 'UTF-8');
        $entryData['field_measure_format'] = htmlspecialchars(trim($entry['fieldMeasureFormat']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_title'] = htmlspecialchars(trim($entry['label']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_description'] = htmlspecialchars(trim($entry['label']), ENT_QUOTES, 'UTF-8');
        $entryData['slug'] = Str::slug($entry['label_id']);

        // Handle additional fields if necessary
        if (isset($entryData['filters'])) {
            $entryData['filters'] = json_encode($entryData['filters'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
        }

        if (isset($entryData['dependencies'])) {
            $entryData['dependencies'] = json_encode($entryData['dependencies'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
        }

        if (isset($entryData['dependencies'])) {
            // JSON encode the permittedvalues field
            $entryData['permittedvalues'] = json_encode($entryData['permittedvalues'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
        }

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
