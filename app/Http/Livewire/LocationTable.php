<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class LocationTable extends Component
{
    public $offices;

    public $locations;

    public function render()
    {

        // Abfrage um alle Offices abzurufen
        $this->offices = $this->getAllOffices();

        $this->getAllLocations();

        return view('livewire.location-table');
    }

    private function getAllOffices()
    {
        $offices = Entry::query()
            ->where('collection', 'standorte')
            ->where('published', true)
            ->get(['office'])
            ->pluck('office')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        return $offices;
    }

    private function getAllLocations()
    {
        $locations = Entry::query()
            ->where('collection', 'standorte')
            ->where('published', true)
            ->get();

        $locationsByOffices = [];

        foreach ($locations as $location) {
            // Angenommen, jede Location hat ein Feld `office_key`, das dem `key` eines Büros entspricht
            $officeKey = $location->get('office');

            // Überprüfen, ob das Büro schon im Array existiert, wenn nicht, initialisieren
            if (! array_key_exists($officeKey, $locationsByOffices)) {
                $locationsByOffices[$officeKey] = [];
            }

            $items = $location->data()->all();

            // Hinzufügen der extrahierten Daten zum entsprechenden Büro
            $locationsByOffices[$officeKey][] = $items;

        }

        $this->locations = $locationsByOffices;

    }
}
