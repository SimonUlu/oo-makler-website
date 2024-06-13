<?php

namespace App\ViewModels;

use App\Services\EstateHandlers\EstateEntryService;
use Statamic\View\ViewModel;

class VermietenViewModel extends ViewModel
{
    public function data(): array
    {
        // get immoglobals from cp globals
        $estateEntryService = new EstateEntryService();

        $estateReferences = $estateEntryService->getEstatesUnpaginated(
            [
                'vermarktungsart' => [
                    [
                        'op' => 'IN',
                        'val' => ['miete'],
                    ],
                ],
            ],
            9,
            'erstellt_am',
            'desc',
            'estate_entries_references'
        );

        return [
            'estateReferences' => $estateReferences,
        ];
    }
}
