<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EstateRelationController extends Component
{
    public $sortBy = 'Id';

    public $sortDirection = 'asc';

    public $selectedSort = 'Id aufsteigend';

    public $subEstates;

    public function mount($subEstates)
    {
        $this->subEstates = $subEstates;
    }

    public function render()
    {
        return view('livewire.estate-relation-controller', [
            'subestates' => $this->subEstates,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;

        // Hier die Sortierung ausführen
        usort($this->subEstates, function ($a, $b) {
            if ($this->sortBy === 'kaufpreis') {
                // Da kaufpreis ein String ist, wird er zu einer Fließkommazahl konvertiert
                return $this->sortDirection === 'asc' ?
                    floatval($a['elements'][$this->sortBy]) <=> floatval($b['elements'][$this->sortBy]) :
                    floatval($b['elements'][$this->sortBy]) <=> floatval($a['elements'][$this->sortBy]);
            }

            // Für andere Werte wie 'Id' oder 'etagen_zahl', die numerisch sind,
            // kann direkt verglichen werden
            return $this->sortDirection === 'asc' ?
                $a['elements'][$this->sortBy] <=> $b['elements'][$this->sortBy] :
                $b['elements'][$this->sortBy] <=> $a['elements'][$this->sortBy];
        });
    }
}
