<?php

namespace App\Jobs;

use App\Services\OnOfficeService;
use DateTime;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Symfony\Component\Yaml\Yaml;

class ImportEstates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $importType
    ) {
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

        // Filter the collection based on the import type and retrieve the specific field
        $filter = collect($globalSet->get('onoffice_default_filter'))
            ->where('onoffice_filter_name', $this->importType)
            ->first();


        if (empty($filter['replicator_field_filter'])) {
            return;
        }

        // Remove filters that are not enabled
        $filter['replicator_field_filter'] = array_filter($filter['replicator_field_filter'], function ($replicatorFilter) {
            return $replicatorFilter['enabled'];
        });

        $filter = OnOfficeService::transformFilterArray($filter);

        $entries = self::getOnOfficeData($apiConnection, $filter);

        if (empty($entries)) {
            return;
        }

        // get existing entries in this collection
        $collectionName = match ($this->importType) {
            'estates_references' => 'estate_entries_references',
            'estates_references_rent' => 'estate_entries_references_rent',
            'estates_full' => 'estate_entries_full',
            default => 'estate_entries',
        };

        // get existing entries in this collection
        $existingEntries = Entry::query()->where('collection', $collectionName)->get();

        // check which entries require update
        $entriesToCreate = collect($entries['records'])->filter(function ($estate) use ($existingEntries) {
            return self::getEstatesToCreate($estate, $existingEntries);
        });

        // get entries that remain unchanged
        $entriesToUpdate = collect($entries['records'])->filter(function ($estate) use ($existingEntries) {
            return self::getEstatesToUpdate($estate, $existingEntries);
        });

        // check which entries require deletion
        $entriesToDelete = collect($existingEntries)->filter(function ($entry) use ($entries) {
            return ! in_array($entry->get('id_internal'), array_column($entries['records'], 'id'));
        });

        $fields = Yaml::parseFile(public_path('estate_fields/estate_fields.yaml'))['defaultFieldsEstate'];

        foreach ($entriesToCreate as $estate) {
            self::createEntry($apiConnection, $estate, $fields, $collectionName);
        }

        foreach ($entriesToUpdate as $estate) {
            self::updateEntry($apiConnection, $estate, $fields, $collectionName);
        }

        foreach ($entriesToDelete as $entry) {
            try {
                $entry->delete();
            } catch (Exception $e) {
                Log::error("Failed to delete entry with id_internal {$entry->get('id_internal')}: {$e->getMessage()}");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function getEstatesToCreate($estate, $existingEntries): bool
    {
        // find the estate in the existing entries
        $existingEstate = $existingEntries->where('id_internal', $estate['id'])->first() ?? null;

        if (isset($existingEstate)) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function getEstatesToUpdate($estate, $existingEntries): bool
    {
        // find the estate in the existing entries
        $existingEstate = $existingEntries->where('id_internal', $estate['id'])->first() ?? null;

        if (! isset($existingEstate)) {
            return false;
        }

        // explicitly set the timezone to UTC when parsing the API date
        $lastChangeFromAPI = Carbon::parse($estate['elements']['geaendert_am'], 'UTC');
        // convert to European time
        $lastChangeFromAPI->setTimezone('Europe/Berlin');

        if(empty($existingEstate->get('geaendert_am'))) {
            return true;
        }
        // explicitly set the timezone to UTC when parsing the existing entry date
        $lastChangeFromEntry = Carbon::parse($existingEstate->get('geaendert_am'), 'UTC');
        // convert to European time
        $lastChangeFromEntry->setTimezone('Europe/Berlin');

        // if change from api is more recent than the change from the entry, update the entry
        if ($lastChangeFromAPI > $lastChangeFromEntry) {
            return true;
        }

        return false;
    }

    /**
     * Get the data from the OnOffice API
     */
    public static function getOnOfficeData(array $apiConnection, array $filter): array
    {
        // get active fields
        $activeFields = app('defaultFieldsEstate');
        // get api handler
        $apiHandler = new \App\Services\OnOffice\Connectors\EstateConnector();

        // get total records count
        return $apiHandler
            ->setConnector($apiConnection)
            ->getRecordChunk(
                filters: $filter,
                params: $activeFields,
            )['data'] ?? [];
    }

    public function getEntryData($entry, $fields, $images): array
    {
        $entryData = [];

        foreach ($fields as $field) {
            $fieldName = key($field);
            $value = $entry['elements'][$fieldName] ?? null;
            $entryData[$fieldName] = match (current($field)) {
                'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                'float' => floatval($value),
                'integer' => intval($value),
                default => htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8'),
            };
        }

        $entryData['id_internal'] = htmlspecialchars(trim($entry['id']), ENT_QUOTES, 'UTF-8');
        $entryData['objektnr_extern'] = htmlspecialchars(trim($entry['elements']['objektnr_extern']), ENT_QUOTES, 'UTF-8');
        $entryData['title'] = htmlspecialchars(trim($entryData['objekttitel']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_title'] = htmlspecialchars(trim($entry['elements']['objekttitel']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_description'] = htmlspecialchars(trim(substr($entry['elements']['objektbeschreibung'], 0, 160)), ENT_QUOTES, 'UTF-8');
        $entryData['estate_images'] = $images;
        $entryData['slug'] = Str::slug($entry['elements']['objekttitel'].'-'.$entry['elements']['objektnr_extern']);

        return $entryData;
    }

    public function createEntry(array $apiConnection, $entry, $fields, string $collectionName): void
    {

        $collection = Collection::findByHandle($collectionName);

        if (! $collection) {
            Log::error("Collection '$collectionName' not found.");

            return;
        }

        $entryData = self::getEntryData($entry, $fields, []);

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

        ImportEstateImages::dispatch($apiConnection, $entryCreated['id_internal'], app('defaultFieldsImages'))->onQueue('sync');
    }

    public function updateEntry(array $apiConnection, $entry, $fields, string $collectionName): void
    {

        $collection = Collection::findByHandle($collectionName);

        if (! $collection) {
            Log::error("Collection '$collectionName' not found.");

            return;
        }

        $existingEntries = Entry::query()->where('collection', $collectionName)->get();

        $entryData = self::getEntryData($entry, $fields, $entry['elements']['images'] ?? null);

        $entryToUpdate = $existingEntries->firstWhere('id_internal', $entryData['id_internal']);

        $entryToUpdate->data($entryData);

        try {
            $entryToUpdate->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        ImportEstateImages::dispatch($apiConnection, $entryToUpdate['id_internal'], app('defaultFieldsImages'))->onQueue('sync');
    }
}
