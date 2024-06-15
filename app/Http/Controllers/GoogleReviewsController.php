<?php

namespace App\Http\Controllers;

use App\Services\GoogleReviewsService;
use Illuminate\Http\Request;

class GoogleReviewsController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->input('language', 'en'); // Default-Wert als 'en'
        $placeId = config('services.google.place_id');
        $apiKey = config('services.google.api_key');

        // Erstelle eine neue Instanz von GoogleReviewsService mit den erforderlichen Parametern
        $googleReviewsService = new GoogleReviewsService($placeId, $apiKey, $language);

        // Hole die Bewertungen
        $reviews = $googleReviewsService->getReviews();
        $num_ratings = $googleReviewsService->getUserRatings();
        $average_rating = $googleReviewsService->getRating();

        $response = [
            'reviews' => $reviews,
            'num_ratings' => $num_ratings,
            'average_rating' => $average_rating,
        ];

        // Gib die zusammengestellten Informationen als JSON zurück
        return response()->json($response);
    }
}
