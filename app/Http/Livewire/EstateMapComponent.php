<?php

namespace App\Http\Livewire;

use App\Helpers\Estates\MapConfiguration;
use Livewire\Component;

class EstateMapComponent extends Component
{
    protected $listeners = ['updateEstateMap' => 'updateEstates'];

    protected $estates;

    public $zoom;

    public $center_lat;

    public $mapboxToken;

    public $center_lng;

    public $style;

    public function mount($estates): void
    {
        $this->estates = $estates;
        $this->mapboxToken = config('api.mapbox.key');
        $this->setInitialConfig();
    }

    public function render()
    {
        return view('livewire.estate-map-component', [
            'estates' => $this->estates,
            'zoom' => $this->zoom,
            'centerLng' => $this->center_lng,
            'centerLat' => $this->center_lat,
            'style' => $this->style,
            'mapboxToken' => $this->mapboxToken,
        ]);
    }

    protected function setInitialConfig(): void
    {
        $config = new MapConfiguration();
        $this->zoom = $config->zoom;
        $this->center_lat = $config->centerLat;
        $this->center_lng = $config->centerLng;
        $this->style = $config->style;
    }

    public function updateEstates($estates): void
    {
        $this->estates = $estates;
        $this->dispatchBrowserEvent('filterUpdated', ['estates' => $this->estates]);
        $this->render();
    }
}
