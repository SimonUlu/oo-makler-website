<?php

namespace App\Pipes;

use Closure;
use Illuminate\Support\Collection;
use Statamic\Entries\Entry;

class EntryFormatFields
{
    public function handle($entries, Closure $next)
    {
        if ($entries instanceof Entry) {
            // Handle single entry
            $this->transformEntryData($entries);
        } elseif (is_array($entries)) {
            // Handle array of entries
            $entries = collect($entries)->map(function ($entry) {
                if ($entry instanceof Entry) {
                    $this->transformEntryData($entry);
                }

                return $entry;
            });
        } elseif ($entries instanceof Collection) {
            // Handle collection of entries
            $entries->transform(function ($entry) {
                if ($entry instanceof Entry) {
                    $this->transformEntryData($entry);
                }

                return $entry;
            });
        }

        return $next($entries);
    }

    private function transformEntryData(Entry $entry): void
    {
        $entry->data()->transform(function ($value) {
            if (is_string($value)) {
                return html_entity_decode($value);
            }

            return $value;
        });
    }
}
