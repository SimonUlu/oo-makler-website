<?php

namespace App\Http\Controllers;

use App\Services\GoogleReviewsService;
use Illuminate\Http\Request;

class GoogleReviewsController extends Controller
{
    private $googleReviewsService;

    public function __construct(GoogleReviewsService $googleReviewsService)
    {
        $this->googleReviewsService = $googleReviewsService;
    }

    public function index(Request $request)
    {
        $placeId = $request->input('place_id');
        $language = $request->input('language');
        $reviews = $this->googleReviewsService->getReviews($placeId, config('api.google.maps.key'), $language);
        // return four random reviews

        return response()->json($reviews);
    }
}
