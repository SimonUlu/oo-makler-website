<?php

namespace App\Http\Livewire;

use Algolia\AlgoliaSearch\SearchClient;
use Livewire\Component;

class EstateSearchComponent extends Component
{
    public $searchTerm = '';

    public function render()
    {
        return view('livewire.estate-search-component', [
            'estates' => $this->searchTerm ? $this->searchEstates() : [],
        ]);
    }

    private function searchEstates()
    {
        // Erstellen Sie eine Algolia-Suche-Client-Instanz
        $searchClient = SearchClient::create(
            config('scout.algolia.id'), // Oder direkt Ihre .env Variablen mit env('ALGOLIA_APP_ID')
            config('scout.algolia.secret') // Oder direkt Ihre .env Variablen mit env('ALGOLIA_SECRET')
        );

        // Initialisieren Sie den Algolia-Index
        $index = $searchClient->initIndex('template_estates');

        // Führen Sie die Suche aus und geben Sie die Ergebnisse zurück
        $searchResults = $index->search($this->searchTerm);

        return $searchResults['hits'];
    }
}
