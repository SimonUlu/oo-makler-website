<?php

namespace App\Http\Livewire;

use App\Models\GeoData;
use Livewire\Component;
use Statamic\Facades\Collection;

class OldDistrictMap extends Component
{
    public $districts;

    public $zipCodeList;

    public $districtJson;

    public $zoom;

    public $mapLong;

    public $mapLat;

    private $collectionData;

    public function mount()
    {
        $this->setDistrictInfo();

        $this->setUniqueZipCodes($this->districts);

        $this->setDistrictJson($this->zipCodeList);

        $this->setMapSettings();

        // dd($this->districtJson);

    }

    public function render()
    {
        $this->districts = json_encode($this->districts);

        return view('livewire.old-district-map');
    }

    private function setUniqueZipCodes($districts)
    {
        $zipCodeList = [];

        foreach ($districts as $district) {
            if (isset($district['plz'])) {
                $zipCodeList[] = $district['plz'];
            }
        }

        $this->zipCodeList = array_unique($zipCodeList);
    }

    private function setDistrictInfo()
    {
        $collectionEntries = Collection::findByHandle('pages')->queryEntries()->where('blueprint', 'stadtbericht')->get('data');

        $this->collectionData = $collectionEntries->map(function ($entry) {
            return $entry->data()->all();
        });

        $this->districts = $this->collectionData[0]['stadtteile'];
    }

    private function setDistrictJson($zipCodes)
    {
        $districtArray = GeoData::whereIn('plz_code', $zipCodes)->get()->toArray();

        $this->districtJson = json_encode($districtArray);
    }

    private function setMapSettings()
    {

        $this->mapLong = $this->collectionData[0]['center_lng'];

        $this->mapLat = $this->collectionData[0]['center_lat'];

        $this->zoom = $this->collectionData[0]['zoom'];
    }
}
