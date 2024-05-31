<?php

namespace App\Pipes;

use Closure;

class FilterEstates
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;

    }

    public function handle($query, Closure $next)
    {

        $filter = $this->filter;

        if (! empty($filter['kaufpreis__von'])) {
            $query->where('kaufpreis', '>=', $filter['kaufpreis__von']);
        }

        if (! empty($filter['kaufpreis__bis'])) {
            $query->where('kaufpreis', '<=', $filter['kaufpreis__bis']);
        }

        if (! empty($filter['anzahl_zimmer__von'])) {
            $query->where('anzahl_zimmer', '>=', $filter['anzahl_zimmer__von']);
        }

        if (! empty($filter['anzahl_zimmer__bis'])) {
            $query->where('anzahl_zimmer', '<=', $filter['anzahl_zimmer__bis']);
        }

        if (! empty($filter['ort'])) {
            $query->whereIn('ort', $filter['ort']);
        }

        if (! empty($filter['vermarktungsart'])) {
            $query->whereIn('vermarktungsart', $filter['vermarktungsart']);
        }

        if (! empty($filter['objektart'])) {
            $query->whereIn('objektart', $filter['objektart']);
        }

        return $next($query);
    }
}
