<?php

namespace App\Http\Livewire;

use App\Models\GeoData;
use Livewire\Component;
use Statamic\Facades\Collection;

class LocationMap extends Component
{
    public $locations;

    public $zoom;

    public $mapLong;

    public $mapLat;

    public function mount() {
        $this->setLocationInfo();
    }


    public function render()
    {
        $this->locations = json_encode($this->locations);

        return view('livewire.location-map');
    }


    private function setLocationInfo()
    {
        $collectionEntries = Collection::findByHandle('pages')->queryEntries()->where('blueprint', 'stadtbericht')->get('data');

        $this->locations = $collectionEntries->flatMap(function ($entry) {
            return $entry->data()->all()["offices"];
        });

    }
}
