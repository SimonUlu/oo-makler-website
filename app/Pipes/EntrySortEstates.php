<?php

namespace App\Pipes;

use Closure;

class EntrySortEstates
{
    protected $sortField;

    protected $sortDirection;

    public function __construct($sortField = 'kaufpreis', $sortDirection = 'asc')
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function handle($estates, Closure $next)
    {
        // Separate estates with the sortField value of 0
        $zeroEstates = $estates->filter(function ($estate) {
            return ($estate[$this->sortField] ?? null) == 0;
        });

        // Filter out estates with the sortField value of 0
        $nonZeroEstates = $estates->reject(function ($estate) {
            return ($estate[$this->sortField] ?? null) == 0;
        });

        // Sort the non-zero estates
        if ($this->sortDirection === 'asc') {
            $sortedEstates = $nonZeroEstates->sortBy(function ($estate) {
                return $estate[$this->sortField] ?? null;
            });
        } else {
            $sortedEstates = $nonZeroEstates->sortByDesc(function ($estate) {
                return $estate[$this->sortField] ?? null;
            });
        }

        // Merge the sorted non-zero estates with the zero estates at the end
        $estates = $sortedEstates->merge($zeroEstates);

        return $next($estates);
    }
}
