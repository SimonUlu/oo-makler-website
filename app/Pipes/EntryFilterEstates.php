<?php

namespace App\Pipes;

use Closure;
use Illuminate\Support\Collection;

class EntryFilterEstates
{
    protected array $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    public function handle(Collection $estates, Closure $next): Collection
    {
        foreach ($this->filter as $key => $conditions) {
            foreach ($conditions as $condition) {
                $op = strtolower($condition['op']);
                $val = $condition['val'];

                $estates = $estates->filter(function ($estate) use ($key, $op, $val) {
                    $estateValue = $estate['elements'][$key] ?? null;

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
                            return is_string($estateValue) && is_string($val)
                                ? strpos(strtolower($estateValue), strtolower($val)) !== false
                                : false;
                        case 'not like':
                            return is_string($estateValue) && is_string($val)
                                ? strpos(strtolower($estateValue), strtolower($val)) === false
                                : false;
                        case 'in':
                            return in_array($estateValue, (array) $val);
                        case 'not in':
                            return ! in_array($estateValue, (array) $val);
                        case 'between':
                            return is_array($val) && count($val) == 2
                                ? $estateValue >= $val[0] && $estateValue <= $val[1]
                                : false;
                        case 'not between':
                            return is_array($val) && count($val) == 2
                                ? $estateValue < $val[0] || $estateValue > $val[1]
                                : false;
                        default:
                            return false;
                    }
                });
            }
        }

        return $next($estates->values());
    }
}
