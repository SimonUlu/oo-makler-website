<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class GlossarGrid extends Component
{

    public $entries;

    public $orderedEntries;

    public function render()
    {
        $this->getAllGlossarArticles();
        return view('livewire.glossar-grid');
    }

    private function getAllGlossarArticles() {

        $entries = Entry::query()
            ->where('collection', 'lexikon')
            ->where('published', true)
            ->get();

        $this->entries = $entries;

        $this->sortEntries();

    }

    private function sortEntries() {
        // Zuerst sortieren wir die Einträge nach dem Titel
        $sortedEntries = $this->entries->sortBy(function ($entry) {
            return $entry['title'];
        })->map(function ($entry) {
            // Konvertiere jedes Entry-Objekt in ein Array
            return $entry->toArray();
        });
    
        // Dann gruppieren wir die sortierten Einträge nach dem ersten Buchstaben des Titels
        $this->orderedEntries = $sortedEntries->groupBy(function ($item) {
            return strtoupper(substr($item['title'], 0, 1));
        })->map(function ($group) {
            // Konvertiere jede Gruppe in ein einfaches Array
            return $group->toArray();
        });

    }
}
