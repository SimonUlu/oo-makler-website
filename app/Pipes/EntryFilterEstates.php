<?php

namespace App\Pipes;

use App\Helpers\Estates\EstateHelper;
use App\Models\GeoData;
use Closure;
use Illuminate\Support\Collection;

class EntryFilterEstates
{
    protected ?array $filter;

    public function __construct(?array $filter)
    {
        $this->filter = $filter;
    }

    public function handle(Collection $estates, Closure $next): Collection
    {
        if (empty($this->filter)) {
            return $next($estates);
        }

        // Prepare filter for onOffice if not done yet
        $filterValid = isset($this->filter[array_key_first($this->filter)][0]['op']) ?? false;

        if (! $filterValid) {
            $filters = EstateHelper::convertFilter(request(), $this->filter);
        } else {
            $filters = array_filter($this->filter);
        }

        foreach ($filters as $key => $filter) {
            // Special handling for distance filter
            if ($key === 'plz' && $filter[0]['op'] === '>=') {
                $originZip = $filter[0]['origin'];
                $maxDistance = $filter[0]['val'];

                // Get coordinates for the origin zip code
                $originCoordinates = GeoData::getCoordinatesForZipCode($originZip);

                if ($originCoordinates) {
                    $estates = $estates->filter(function ($estate) use ($originCoordinates, $maxDistance) {
                        $estateZip = is_array($estate) ? ($estate['plz'] ?? null) : ($estate->get('plz') ?? null);

                        if ($estateZip) {
                            $estateCoordinates = GeoData::getCoordinatesForZipCode($estateZip);

                            if ($estateCoordinates) {
                                $distance = $this->calculateDistance($originCoordinates, $estateCoordinates);

                                return $distance <= $maxDistance;
                            }
                        }

                        return false;
                    });
                }

                continue;
            }

            // Convert filter to onOffice filter
            $op = strtolower($filter[0]['op']);
            $val = $filter[0]['val'];

            $estates = $estates->filter(function ($estate) use ($key, $op, $val) {
                // Check if $estate is an array or a collection and get the value accordingly
                $estateValue = is_array($estate) ? ($estate[$key] ?? null) : ($estate->get($key) ?? null);

                if (! isset($estateValue)) {
                    return false;
                }

                switch ($op) {
                    case '=':
                        return is_string($estateValue) && is_string($val)
                            ? strtolower($estateValue) === strtolower($val)
                            : $estateValue == $val;
                    case '!=':
                    case '<>':
                        return $estateValue != $val;
                    case '>':
                        return $estateValue > $val;
                    case '<':
                        return $estateValue < $val;
                    case '>=':
                        return $estateValue >= $val;
                    case '<=':
                        return $estateValue <= $val;
                    case 'like':
                        return is_string($estateValue) && is_string($val) && str_contains(strtolower($estateValue), strtolower($val));
                    case 'not like':
                        return is_string($estateValue) && is_string($val) && ! str_contains(strtolower($estateValue), strtolower($val));
                    case 'in':
                        $lowercaseVal = array_map('strtolower', (array) $val);

                        return in_array(strtolower($estateValue), $lowercaseVal);
                    case 'not in':
                        $lowercaseVal = array_map('strtolower', (array) $val);

                        return ! in_array(strtolower($estateValue), $lowercaseVal);
                    case 'between':
                        return is_array($val) && count($val) == 2 && $estateValue >= $val[0] && $estateValue <= $val[1];
                    case 'not between':
                        return is_array($val) && count($val) == 2 && ($estateValue < $val[0] || $estateValue > $val[1]);
                    default:
                        return false;
                }
            });
        }

        return $next($estates->values());
    }

    /**
     * Calculate the distance between two sets of coordinates using the Haversine formula.
     *
     * @param  array  $coordinates1
     * @param  array  $coordinates2
     */
    private function calculateDistance($coordinates1, $coordinates2): float|int
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $lat1 = deg2rad($coordinates1['lat']);
        $lon1 = deg2rad($coordinates1['lon']);
        $lat2 = deg2rad($coordinates2['lat']);
        $lon2 = deg2rad($coordinates2['lon']);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
