<?php

namespace App\ViewModels;

use App\Helpers\Estates\EstateHelper;
use App\Http\Controllers\UserController as ControllersUserController;
use App\Services\OnOfficeService;
use Statamic\View\ViewModel;

class SingleDistrictViewModel extends ViewModel
{
    public function data(): array
    {
        $onOfficeService = new OnOfficeService();

        // get uip ocde of current page
        $zip_code = $this->cascade->get('postleitzahl');

        // set general filter for zip-codes
        $filter = ['plz' => [
            ['op' => '=', 'val' => $zip_code],
        ]];

        // set filter for sell
        $sell_filter = ['vermarktungsart' => [
            ['op' => '=', 'val' => 'kauf'],
        ]];

        // set filter for rent
        $rent_filter = ['vermarktungsart' => [
            ['op' => '=', 'val' => 'miete'],
        ]];

        $sell_estates = EstateHelper::getEstatesWithImages(request(), $onOfficeService, array_merge($filter, $sell_filter), 0, 500, 'estateReferences', 'estateReferenceImages');
        $rent_estates = EstateHelper::getEstatesWithImages(request(), $onOfficeService, array_merge($filter, $rent_filter), 0, 500, 'estateReferences', 'estateReferenceImages');
        $user_sell_estates = ControllersUserController::concatenateUsers($sell_estates);
        $user_rent_estates = ControllersUserController::concatenateUsers($rent_estates);

        // Rückgabe der Daten an das View
        return [
            'buyEstates' => $user_sell_estates,
            'rentEstates' => $user_rent_estates,
        ];
    }
}
