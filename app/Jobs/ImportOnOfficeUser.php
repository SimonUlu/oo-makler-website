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
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class ImportOnOfficeUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const FIELDS = [
        'Anrede',
        'Titel',
        'Kuerzel',
        'Vorname',
        'Nachname',
        'Firma',
        'PLZ',
        'Ort',
        'Strasse',
        'Hausnummer',
        'Land',
        'province',
        'Mobil',
        'Telefon',
        'Url',
        'Firmazusatz1',
        'PositionUnternehmen',
        'Nr',
        'Name',
        'email',
        'Emailname',
        'meetingUrl',
    ];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->queue = 'sync-onoffice';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Retrieve the global set
        $globalSet = GlobalSet::find('onoffice')->in('default');

        $apiConnection = [
            'token' => $globalSet->get('onoffice_token'),
            'secret' => $globalSet->get('onoffice_secret'),
        ];

        $entries = self::getOnOfficeUser($apiConnection);

        if (empty($entries)) {
            return;
        }

        // get existing entries in this collection
        $collectionName = 'on_office_users';

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

        // create the new entries
        foreach ($entries as $entry) {
            self::createEntry($entry, $collectionName);
        }
    }

    /**
     * Get the data from the OnOffice API
     */
    public static function getOnOfficeUser(array $apiConnection): array
    {
        // get api handler
        $apiHandler = new \App\Services\OnOffice\Connectors\UserConnector();

        // get total records count
        $userData = $apiHandler
            ->setConnector($apiConnection)
            ->getRecordChunk(
                params: self::FIELDS,
            );

        foreach ($userData as $key => $record) {
            $userImage = $apiHandler
                ->setConnector($apiConnection)
                ->getProfilePhoto(
                    $record['id'],
                );

            $userData[$key]['elements']['photo'] = $userImage;
        }

        return $userData;
    }

    public function getEntryData($entry, $fields): array
    {
        $entryData = [];

        foreach ($fields as $fieldName) {
            $entryData[$fieldName] = $entry['elements'][$fieldName] ?? null;
        }

        // Encode complex fields as JSON
        $entryData['title'] = htmlspecialchars(trim($entryData['Name']), ENT_QUOTES, 'UTF-8');
        $entryData['id_internal'] = htmlspecialchars(trim($entryData['Name']), ENT_QUOTES, 'UTF-8');
        $entryData['photo'] = htmlspecialchars(trim($entry['elements']['photo']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_title'] = htmlspecialchars(trim($entryData['Name']), ENT_QUOTES, 'UTF-8');
        $entryData['seo_description'] = htmlspecialchars(trim($entryData['Name']), ENT_QUOTES, 'UTF-8');
        $entryData['slug'] = Str::slug($entryData['Name']);

        return $entryData;
    }

    public function createEntry($entry, string $collectionName): void
    {

        $collection = Collection::findByHandle($collectionName);

        if (! $collection) {
            Log::error("Collection '$collectionName' not found.");

            return;
        }

        $entryData = self::getEntryData($entry, self::FIELDS);
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
