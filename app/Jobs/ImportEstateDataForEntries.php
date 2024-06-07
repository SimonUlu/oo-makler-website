<?php

namespace App\Jobs;

use App\Services\OnOfficeService;
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
use Symfony\Component\Yaml\Yaml;

class ImportEstateDataForEntries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public bool $importPublished = true,
        public bool $importReferences = true
    ) {
        //
    }

    public function handle(): void
    {

        $filterValue = GlobalSet::find('onoffice')->in('default')->get('oo_field_value');
        $filterField = GlobalSet::find('onoffice')->in('default')->get('oo_field_name');
        $filterOperator = GlobalSet::find('onoffice')->in('default')->get('oo_field_operator');

        // Define the base filters and collection names for both conditions
        $baseFilters = [
            'published' => [
                'filters' => [
                    'referenz' => [
                        ['op' => '=', 'val' => 0],
                    ],
                    $filterField => [
                        ['op' => $filterOperator, 'val' => $filterValue],
                    ],
                    'stammobjekt' => [
                        ['op' => '=', 'val' => 0],
                    ],
                ],
                'collectionName' => 'estate_entries',
            ],
            'references' => [
                'filters' => [
                    'referenz' => [
                        ['op' => '=', 'val' => 1],
                    ],
                    $filterField => [
                        ['op' => $filterOperator, 'val' => $filterValue],
                    ],
                    'stammobjekt' => [
                        ['op' => '=', 'val' => 0],
                    ],
                ],
                'collectionName' => 'estate_entries_references',
            ],
        ];

        // Check and call importEstates for published estates
        if ($this->importPublished) {
            $this->importEstates($baseFilters['published']['collectionName'], $baseFilters['published']['filters']);
        }

        // Check and call importEstates for references
        if ($this->importReferences) {
            $this->importEstates($baseFilters['references']['collectionName'], $baseFilters['references']['filters']);
        }
    }

    public function importEstates(string $collectionName, array $filters): void
    {
        $collection = Collection::findByHandle($collectionName);
        if (! $collection) {
            Log::error("Collection '$collectionName' not found.");

            return;
        }

        $existingEntries = Entry::query()->where('collection', $collectionName)->get();
        $existingObjektnrExtern = $existingEntries->pluck('objektnr_extern')->toArray();

        $onOfficeService = new OnOfficeService();
        $estates = $onOfficeService->getEstatesWithImagesExtended($filters, 0, 500);

        $fields = Yaml::parseFile(public_path('estate_fields/estate_fields.yaml'))['defaultFieldsEstate'];

        // Keep track of processed slugs
        $processedEntries = [];

        foreach ($estates as $estate) {
            $has_been_updated = self::checkUpdates($estate, $existingEntries);

            if (! $has_been_updated) {
                $objektnr_extern = $estate['elements']['objektnr_extern'];

                $processedEntries[] = $objektnr_extern;

                continue;
            } else {
                $objektnr_extern = $estate['elements']['objektnr_extern'];

                // Skip processing if the estate is a duplicate based on objektnr_extern
                $processedEntries[] = $objektnr_extern;

                $entry = $existingEntries->firstWhere('objektnr_extern', $objektnr_extern);
                $entryData = $entry ? $entry->data()->toArray() : [];

                if ($entry) {
                    $entry->delete();
                    $entry = null;
                }

                foreach ($fields as $field) {
                    $fieldName = key($field);
                    $value = $estate['elements'][$fieldName] ?? null;
                    $entryData[$fieldName] = match (current($field)) {
                        'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                        'float' => floatval($value),
                        'integer' => intval($value),
                        default => $value,
                    };
                }

                $entryData['estate_images'] = collect($estate['elements']['images'] ?? [])->map(fn ($image) => [
                    'type' => 'image',
                    'url' => $image['url'],
                ])->all();

                $entryData['id_internal'] = isset($estate['id']) ? $estate['id'] : $estate['elements']['Id'] ?? null;
                $entryData['title'] = $entryData['objekttitel'];
                $entryData['objektnr_extern'] = $estate['elements']['objektnr_extern'];
                $entryData['seo_title'] = $estate['elements']['objekttitel'];
                $entryData['seo_description'] = substr($estate['elements']['objektbeschreibung'], 0, 160);

                $slug = Str::slug($estate['elements']['objekttitel'].'-'.$estate['elements']['objektnr_extern']);

                if (! $entry) {
                    $entry = Entry::make()
                        ->collection($collection->handle())
                        ->blueprint($collection->entryBlueprint())
                        ->slug($slug)
                        ->data($entryData);
                } else {
                    $entry->data($entryData);
                }

                try {
                    $entry->save();
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        // Identify slugs of entries that were not processed (and hence should be deleted)
        $entriesToDelete = array_diff($existingObjektnrExtern, $processedEntries);

        // Delete entries with these slugs
        $entriesToDelete = Entry::query()->where('collection', $collectionName)->whereIn('objektnr_extern', $entriesToDelete)->get();

        foreach ($entriesToDelete as $entryToDelete) {
            try {
                $entryToDelete->delete();
            } catch (Exception $e) {
                Log::error("Failed to delete entry with slug {$entryToDelete->slug()}: {$e->getMessage()}");
            }
        }
    }

    private function checkUpdates($estate, $existingEntries)
    {

        $objnr_extern = $estate['elements']['objektnr_extern'];

        //# if modified within last 24 hours then return true
        $geaendertAm = new \DateTime($estate['elements']['geaendert_am']);

        $difference_hours = self::calculate_hour_difference($geaendertAm);

        if ($difference_hours < 24) {
            // less than 24 hours
            return true;
        } else {
            $entry = $existingEntries->firstWhere('objektnr_extern', $objnr_extern);

            // check if entry exists
            if ($entry) {
                $oo_images = $estate['elements']['images'];

                // Extrahiere URLs aus der ersten Quelle
                $oo_image_urls = array_map(function ($image) {
                    return $image['url'];
                }, $oo_images);

                // Extrahiere URLs aus der zweiten Quelle
                $entry_image_urls = array_map(function ($image) {
                    return $image['url'];
                }, $entry->data()->toArray()['estate_images']);
                sort($oo_image_urls);
                sort($entry_image_urls);

                // Wenn die Arrays identisch sind (gleiche URLs in gleicher Anzahl), gib false
                $result = $oo_image_urls !== $entry_image_urls;

                return $result;
            } else {
                // return true if this does not exist
                return true;
            }
        }
    }

    private function calculate_hour_difference($geaendertAm)
    {
        $now = new \DateTime();
        $difference = $now->diff($geaendertAm);

        $difference_hours = $difference->days * 24 + $difference->h;

        return $difference_hours;
    }
}
