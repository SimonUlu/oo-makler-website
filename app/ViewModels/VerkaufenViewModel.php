<?php

namespace App\ViewModels;

use App\Services\EstateHandlers\EstateEntryService;
use Statamic\View\ViewModel;

class VerkaufenViewModel extends ViewModel
{
    public function data(): array
    {
        // get immoglobals from cp globals
        $estateEntryService = new EstateEntryService();

        $estateReferences = $estateEntryService->getEstatesUnpaginated(
            [
                'vermarktungsart' => [
                    [
                        'op' => 'in',
                        'val' => ['kauf'],
                    ],
                ],
            ],
            3,
            'erstellt_am',
            'desc',
            'estate_entries_references'
        );

        return [
            'estates' => $estateReferences,
        ];
    }
}
