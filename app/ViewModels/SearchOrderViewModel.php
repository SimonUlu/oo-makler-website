<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class SearchOrderViewModel extends ViewModel
{
    public function data(): array
    {
        return [
            'title' => 'Searchorder',
            'searchorder' => 'This is the searchorder page',
            'minRooms' => 0,
            'maxRooms' => 10,
            'minPrice' => 0,
            'maxPrice' => 1000000,
            'vermarktungsart' => 'kauf',
        ];
    }
}
