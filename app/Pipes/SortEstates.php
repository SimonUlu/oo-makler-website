<?php

namespace App\Pipes;

use Closure;

class SortEstates
{
    protected $field;

    protected $direction;

    public function __construct($field = 'kaufpreis', $direction = 'asc')
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    // sort by fieldname in direction
    public function handle($query, Closure $next)
    {
        $query->orderBy($this->field, $this->direction); //direction = "asc" || "desc"

        return $next($query);
    }

    // factory method
    public static function withParameters($field, $direction)
    {
        return new static($field, $direction);
    }
}
