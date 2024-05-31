<?php

namespace App\Modifiers;

use App\Jobs\ImportStatisticsDataForEntries;
use Illuminate\Support\Str;
use Statamic\Facades\Entry;
use Statamic\Modifiers\Modifier;

class StatisticsModifier extends Modifier
{
    public function index($identifier, $params, $context)
    {
        $before = '';
        $after = '';

        if (! $identifier) {
            return null;
        }

        // check if statistics are filled in entries
        $entries = Entry::query()->where('collection', 'statistic_entries')->get();

        // if entries is empty, do ImportEstateDataForEntries
        if (! $entries->isEmpty()) {
            $entry = collect($entries)->where('title', $identifier)->first();
        } else {
            ImportStatisticsDataForEntries::dispatch($identifier);

            return null;
        }
        // add before and after modifiers
        foreach ($params[0] as $param) {
            if (Str::contains($param, 'before')) {
                $before = explode(':', $param)[1];
            }
            if (Str::contains($param, 'after')) {
                $after = explode(':', $param)[1];
            }
        }

        $statValue = number_format($entry['statistic_value'], 0, ',', '.');

        if ($before) {
            $statistic = $before.$statValue;
        }
        if ($after) {
            $statistic = $statValue.$after;
        }

        return $statistic;
    }
}
