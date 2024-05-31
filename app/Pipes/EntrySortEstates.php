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
        if ($this->sortDirection === 'asc') {
            $estates = $estates->sortBy(function ($estate) {
                return $estate['elements'][$this->sortField] ?? null;
            });
        } else {
            $estates = $estates->sortByDesc(function ($estate) {
                return $estate['elements'][$this->sortField] ?? null;
            });
        }

        return $next($estates);
    }
}
