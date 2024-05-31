<?php

namespace App\Tags;

use App\Http\Controllers\EstateController;
use App\Services\OnOfficeService;
use Illuminate\Http\Request;
use Statamic\Tags\Tags;

class EstatesTag extends Tags
{
    protected static $handle = 'estatesTag';

    public function index()
    {
        $request = resolve(Request::class);
        $onOfficeService = resolve(OnOfficeService::class);
        $estatesController = resolve(EstateController::class);
        $viewWithData = $estatesController->index($request, $onOfficeService);

        $estates = $viewWithData->getData()['estatesTag'];

        return $estates;
    }
}
