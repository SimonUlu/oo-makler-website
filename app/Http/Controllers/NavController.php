<?php

namespace App\Http\Controllers;

use Statamic\Facades\Nav;

// clas only to test all navigation links working
class NavController
{
    public function index()
    {
        $navigation = Nav::find('main');

        $tree = $navigation->in('default')->tree();

        $links = $this->extractLinks($tree);

        return response()->json($links);
    }

    protected function extractLinks($items, &$links = [])
    {
        foreach ($items as $item) {
            if (isset($item['children'])) {
                foreach ($item['children'] as $children) {
                    $links[] = [
                        'title' => $children['title'],
                        'url' => $children['url'],
                    ];
                }
            } else {
                $links[] = [
                    'title' => $item['title'],
                    'url' => $item['url'],
                ];
            }
        }

        return $links;
    }
}
