<?php

namespace App\Helpers\Filters;

class SortOption
{
    public $direction;

    public $onOfficeField;

    public $isStandardOption;

    public $optionText;

    public $showOnlyMiete = false;

    public $showOnlyKauf = false;

    public $showAll = false;

    public $id;

    public function __construct($direction, $onOfficeField, $isStandardOption, $optionText, $id)
    {
        $this->direction = $direction;
        $this->onOfficeField = $onOfficeField;
        $this->isStandardOption = $isStandardOption;
        $this->optionText = $optionText;
        $this->id = $id;
    }

    public function setType($type)
    {

        switch ($type) {
            case 'Miete':
                $this->showOnlyMiete = true;
                break;
            case 'Kauf':
                $this->showOnlyKauf = true;
                break;
            case 'All':
                $this->showAll = true;
                break;
        }
    }

    public function shouldDisplay($filter)
    {

        $types = $filter['vermarktungsart'] ?? [];

        // Zuerst überprüfen wir, ob $types tatsächlich ein Array ist und konvertieren es, falls nicht
        if (! is_array($types)) {
            $types = [$types];
        }

        // Überprüfen, ob "Miete" oder "Kauf" im Array enthalten ist
        $containsMiete = in_array('Miete', $types);
        $containsKauf = in_array('Kauf', $types);

        // Logik zur Bestimmung, ob angezeigt werden soll
        if ($this->showAll) {
            return true;
        } elseif ($this->showOnlyMiete && $containsMiete && ! $containsKauf) {
            // Zeige nur, wenn ausschließlich "Miete" im Array ist
            return true;
        } elseif ($this->showOnlyKauf && $containsKauf && ! $containsMiete) {
            // Zeige nur, wenn ausschließlich "Kauf" im Array ist
            return true;
        }

        // Wenn keine der Bedingungen zutrifft, nicht anzeigen
        return false;
    }

    public function setStandardOption($standardOption) {}
}
