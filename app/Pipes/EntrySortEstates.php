<?php

namespace App\Pipes;

use Closure;
use Illuminate\Support\Carbon;

class EntrySortEstates
{
    protected mixed $sortField;
    protected mixed $sortDirection;

    public function __construct($sortField = 'kaufpreis', $sortDirection = 'asc')
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function handle($estates, Closure $next)
    {
        if (empty($estates)) {
            return $next($estates);
        }

        // Separate estates with the sortField value of 0 or null
        $zeroEstates = $estates->filter(function ($estate) {
            return $this->isZeroOrNull($estate[$this->sortField] ?? null);
        });

        // Filter out estates with the sortField value of 0 or null
        $nonZeroEstates = $estates->reject(function ($estate) {
            return $this->isZeroOrNull($estate[$this->sortField] ?? null);
        });

        // Sort the non-zero estates
        if ($this->sortDirection === 'asc') {
            $sortedEstates = $nonZeroEstates->sortBy(function ($estate) {
                return $this->normalizeValue($estate[$this->sortField] ?? null);
            });
        } else {
            $sortedEstates = $nonZeroEstates->sortByDesc(function ($estate) {
                return $this->normalizeValue($estate[$this->sortField] ?? null);
            });
        }

        // Merge the sorted non-zero estates with the zero estates at the end
        $estates = $sortedEstates->merge($zeroEstates);

        return $next($estates);
    }

    protected function isZeroOrNull($value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_numeric($value)) {
            return $value == 0;
        }

        return false;
    }

    protected function normalizeValue($value)
    {
        if ($value instanceof Carbon) {
            return $value->timestamp;
        }

        return $value;
    }
}
