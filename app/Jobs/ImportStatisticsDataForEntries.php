<?php

namespace App\Jobs;

use App\Services\OnOfficeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\Entry;
use Symfony\Component\Yaml\Yaml;

class ImportStatisticsDataForEntries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?string $identifier = null
    ) {
        $this->queue = 'sync-onoffice';
    }

    public function handle(): void
    {
        if ($this->identifier) {
            $this->loadStat($this->identifier);
        } else {
            // check if statistics are filled in entries
            $entries = Entry::query()->where('collection', 'statistic_entries')->get();

            if (! $entries->isEmpty()) {
                $statistics = $entries->toArray();
            } else {
                return;
            }

            foreach ($statistics as $statistic) {
                if (! isset($statistic['title'])) {
                    continue;
                }
                $this->loadStat($statistic['title']);
            }
        }
    }

    public function loadStat($identifier): void
    {
        $onOfficeService = new OnOfficeService();
        $statistics = $onOfficeService->getStatistics($identifier);

        $yamlPath = public_path('statistic_fields/statistic_fields.yaml');
        $yamlContents = Yaml::parseFile($yamlPath);
        $fields = $yamlContents['defaultFieldsStatistics'];

        $slug = \Illuminate\Support\Str::slug($statistics['title']);

        $entry = Entry::query()->where('collection', 'statistic_entries')->where('slug', $slug)->first();

        foreach ($fields as $field) {
            $fieldName = key($field);
            $fieldType = current($field);

            $value = $statistics[$fieldName] ?? null;

            if ($fieldType === 'boolean') {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            } elseif ($fieldType === 'float') {
                $value = floatval($value);
            } elseif ($fieldType === 'integer') {
                $value = intval($value);
            } elseif ($fieldType === 'date') {
                $value = date('Y-m-d H:i:s', strtotime($value));
            }

            $entryData[$fieldName] = $value;
        }

        // erstelle oder update den Eintrag
        if ($entry) {
            $entry->data($entryData);
            $entry->save();
        } else {
            Entry::make()
                ->collection('statistic_entries')
                ->slug($slug)
                ->data($entryData)
                ->save();
        }
    }
}
