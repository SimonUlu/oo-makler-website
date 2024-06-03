<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Statamic\Facades\Entry;

class NewsController extends Component
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

        $this->filterPosts($query);

        return view('livewire.news-controller', ['posts' => $this->posts]);
    }

    private function filterPosts($query)
    {
        if (! empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        if (! empty($this->searchString)) {
            $query->where('title', 'like', '%'.$this->searchString.'%'); // Sucht nach Posts, deren Titel den Suchbegriff enthalten
        }

        $this->posts = $query->limit(10)->get();
    }
}
