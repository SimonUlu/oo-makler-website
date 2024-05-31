<?php

namespace App\Http\Controllers;

use App\Jobs\ImportEstateDataForEntries;
use Illuminate\Http\Request;

class EstateRefreshController extends Controller
{
    public function refresh(Request $request)
    {
        // Dispatch the job to refresh the collection
        ImportEstateDataForEntries::dispatch();

        return response()->json(['status' => 'success', 'message' => 'Estate collection refresh initiated.']);
    }
}
