<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class NewsController extends Component
{
    protected $posts;

    public $selectedCategory = ''; // Hier wird die ausgewählte Kategorie gespeichert.

    public $categories = []; //

    public function mount()
    {

    }

    public function render()
    {
        // Abfrage, um alle Kategorien aus deinen Posts abzurufen.
        $this->categories = Entry::query()
            ->where('collection', 'news')
            ->where('published', true)
            ->get(['category'])
            ->pluck('category')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Abfrage, um Posts basierend auf der ausgewählten Kategorie zu holen.
        $query = Entry::query()
            ->where('collection', 'news')
            ->where('published', true);

        if (! empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        $this->posts = $query->limit(5)->get();

        return view('livewire.news-controller', ['posts' => $this->posts]);
    }
}
