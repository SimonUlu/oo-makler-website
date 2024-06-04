<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class LexikonController extends Component
{
    protected $posts;

    public $selectedCategory = '';

    public $categories = [];

    public $searchString = '';

    public function mount()
    {

    }

    public function render()
    {
        // Abfrage, um alle Kategorien aus deinen Posts abzurufen.
        $this->categories = Entry::query()
            ->where('collection', 'faq')
            ->where('published', true)
            ->get(['category'])
            ->pluck('category')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        $this->categories = array_shift($this->categories);

        // Abfrage, um Posts basierend auf der ausgewählten Kategorie zu holen.
        $query = Entry::query()
            ->where('collection', 'faq')
            ->where('published', true);

        $this->filterPosts($query);

        return view('livewire.lexikon-controller', 
            [
                'posts' => $this->posts,
                'categories' => $this->categories,
            ]
        );
    }

    private function filterPosts($query)
    {

        if (! empty($this->searchString)) {
            $query->where('title', 'like', '%'.$this->searchString.'%'); // Sucht nach Posts, deren Titel den Suchbegriff enthalten
        }

        $this->posts = $query->limit(10)->get();

        if (!empty($this->selectedCategory)) {
            $this->posts = $this->posts->filter(function ($entry) {
                // Zugriff auf die Kategorie-Daten des Eintrags
                $categories = $entry->get('category', []);

                dd($categories);
        
                // Prüfen, ob die ausgewählte Kategorie in den Kategorien des Eintrags enthalten ist
                return in_array($this->selectedCategory, $categories);
            });
        }

    }
}
