<?php

namespace App\Services\StringParseService;

use TheIconic\NameParser\Language\German;
use TheIconic\NameParser\Parser;

class NameParser
{
    public static function parseName($data)
    {
        $parser = new Parser([
            new German(),
        ]);
        $name = $parser->parse($data);

        return collect([
            // [
            //     $name->getSalutation(),
            //     'salutation',
            // ],
            'anrede' => $name->getSalutation(),
            'vorname' => $name->getFirstname().$name->getMiddlename(),
            'name' => $name->getLastname(),
        ]);
    }
}
