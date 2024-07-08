<?php

namespace App\Http\Controllers;

use App\Jobs\ImportEstates;
use Exception;
use Illuminate\Http\Request;

class EstateRefreshController extends Controller
{
    /**
     * @throws Exception
     */
    public function refresh(Request $request)
    {
        // Dispatch the job to refresh the collection
        //        $jobFull = new ImportEstates('estates_full');
        //        $jobFull->handle();

        ImportEstates::dispatch('estates_on_market')->onQueue('sync-onoffice');
        //        $jobReferences = new ImportEstates('estates_references');
        //        $jobReferences->handle();

        return response()->json(['status' => 'success', 'message' => 'Estate collection refresh initiated.']);
    }
}
