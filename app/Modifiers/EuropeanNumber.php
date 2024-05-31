<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class EuropeanNumber extends Modifier
{
    public static function index($value, $decimals)
    {
        // get decimals in proper format
        $decimals = is_array($decimals) ? (int) $decimals[0] : (int) $decimals;
        // Convert the value to a float.
        $number = (float) $value;
        // Add a round to the number.
        $number = round($number, $decimals);

        return number_format($number, $decimals, $decimalSeparator = ',', $thousandsSeparator = '.');
    }
}
