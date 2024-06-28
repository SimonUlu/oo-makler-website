<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class GlossarGrid extends Component
{
    public $entries;

    public $orderedEntries;

    public $searchString = '';

    public function render()
    {
        $this->getAllGlossarArticles();

        return view('livewire.glossar-grid');
    }

    private function getAllGlossarArticles()
    {

        $entries = Entry::query()
            ->where('collection', 'lexikon')
            ->where('published', true);

        $this->entries = $entries;

        $this->filterEntries($entries);

        $this->sortEntries();

    }

    private function filterEntries($query)
    {

        if (! empty($this->searchString)) {
            $query->where('title', 'like', '%'.$this->searchString.'%'); // Sucht nach Posts, deren Titel den Suchbegriff enthalten
        }

        $this->entries = $query->get();

        if (! empty($this->selectedCategory)) {
            $this->entries = $this->posts->filter(function ($entry) {
                // Zugriff auf die Kategorie-Daten des Eintrags
                $categories = $entry->get('category', []);

                // Prüfen, ob die ausgewählte Kategorie in den Kategorien des Eintrags enthalten ist
                return in_array($this->selectedCategory, $categories);
            });
        }

    }

    private function sortEntries()
    {
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
