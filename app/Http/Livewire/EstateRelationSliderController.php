<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EstateRelationSliderController extends Component
{
    public $subEstates;

    public function mount($subEstatesData)
    {
        $this->subEstates = $subEstatesData;
    }

    public function render()
    {
        return view('livewire.estate-relation-slider-controller', [
            'subestates' => $this->subEstates,
        ]);
    }
}
