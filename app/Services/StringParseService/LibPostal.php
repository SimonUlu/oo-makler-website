<?php

namespace App\Services\StringParseService;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LibPostal
{
    public static function parseAddress(string $data): Collection
    {
        $raw = collect(json_decode(Http::get('address-parser.inno-brain.de/parse?address='.$data)));
        $cleaned = self::getValues($raw);

        return self::defaultValues($cleaned, $data);
    }

    private static function getValues(Collection $data): Collection
    {
        $road = $data->where(fn ($item) => $item[1] === 'road')->flatten()[0] ?? '';
        $postcode = $data->where(fn ($item) => $item[1] === 'postcode')->flatten()[0] ?? '';
        $city = $data->where(fn ($item) => $item[1] === 'city')->flatten()[0] ?? '';
        $housenumber = $data->where(fn ($item) => $item[1] === 'house_number')->flatten()[0] ?? '';

        return collect([
            'street' => Str::title($road),
            'house_number' => Str::title($housenumber),
            'zip_code' => Str::title($postcode),
            'city' => Str::title($city),
        ]);
    }

    private static function defaultValues(Collection $cleaned, string $data): Collection
    {
        if ($cleaned['street'] == '') {
            $cleaned['street'] = $data;
        }

        return $cleaned;
    }
}
