<?php

namespace App\ViewModels;

use App\Services\EstateHandlers\EstateEntryService;
use Statamic\View\ViewModel;

class ReferenzenViewModel extends ViewModel
{
    public function data(): array
    {
        // get immoglobals from cp globals
        $estateEntryService = new EstateEntryService();

        $estateReferences = $estateEntryService->getEstatesUnpaginated(
            [],
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
