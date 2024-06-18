<?php

use App\Http\Controllers\EstateController;
use App\Http\Controllers\GoogleReviewsController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectController;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Collection;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('immobilien')->name('immobilien.')->group(function () {
    Route::get('/{vermarktungsart?}', [EstateController::class, 'index'])
        ->whereIn('vermarktungsart', ['kauf', 'miete'])
        ->name('index');
    Route::get('/details/{id}', [EstateController::class, 'show'])
        ->middleware('track_visits')
        ->name('show');
});

// The route to the RSS feed.
Route::statamic('/feed/news', 'feed/feed', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

// Google Reviews
Route::get('google-reviews', [GoogleReviewsController::class, 'index']);
// custom reviews like immoscout 24
Route::get('!bewertungen', function () {

    // Disable the debugbar for this route
    Debugbar::disable();

    $bewertungen = Collection::find('bewertungen')->queryEntries()->get();

    return $bewertungen->toJson();
});

// routes for search order
// route for redirect()->route('searchcriteria.error');
Route::statamic('suchauftrag-fehler', 'pages/suchauftrag/error', [
    'title' => 'Suchauftrag fehlgeschlagen',
])->name('searchcriteria.error');
// rout for redirect()->route('searchcriteria.success');
Route::statamic('suchauftrag-erfolgreich-angemeldet', 'pages/suchauftrag/success', [
    'title' => 'Suchauftrag erfolgreich angemeldet',
])->name('searchcriteria.success');

Route::statamic('suchauftrag/{vermarktungsart?}', 'pages/suchauftrag/new')->name('suchauftrag');

// Newsletter
Route::post('newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

Route::statamic('newsletter-erfolgreich-angemeldet', 'pages/newsletter/newsletter-success', [
    'title' => 'Newsletter erfolgreich angemeldet',
])->name('newsletter.success');

Route::statamic('newsletter', 'pages/newsletter/newsletter', [
    'title' => 'Newsletter',
]);

// make a redirect from /immobilien/kaufen to /immobilien?filter[vermarktungsart][0]=Kauf
Route::redirect('/immobilien/kaufen', '/immobilien?filter[vermarktungsart][0]=Kauf');
// make a redirect from /immobilien/mieten to /immobilien?filter[vermarktungsart][0]=Miete
Route::redirect('/immobilien/mieten', '/immobilien?filter[vermarktungsart][0]=Miete');

Route::post('immobilien', [EstateController::class, 'index'])->name('immobilien.filtered');

Route::statamic('bewertungstool', 'pages/estate_assessment/estate_assessment', [
    'title' => 'Immobilienbewertung',
]);

Route::get('!referenzen', function () {

    // Disable the debugbar for this route
    Debugbar::disable();

    $bewertungen = Collection::find('referenzen')->queryEntries()->get();

    return $bewertungen->toJson();
});

Route::statamic('kontakt-erfolgreich', 'pages/contact/contact-sucess', [
    'title' => 'Kontaktanfrage erfolgreich versendet',
])->name('contact.success');

Route::statamic('kontakt-fehler', 'pages/contact/contact-error', [
    'title' => 'Kontaktanfrage erfolgreich versendet',
])->name('contact.error');

// For neubauprojekte
Route::prefix('neubauprojekte')->name('projects.')->group(function () {
    Route::get('/{vermarktungsart?}', [ProjectController::class, 'index'])
        ->name('index');
    Route::get('/details/{id}', [ProjectController::class, 'show'])
        ->name('show');
});

// Route to get google reviews
Route::get('/api/google-places-reviews', function (Request $request) {
    // Stellen Sie sicher, dass die notwendigen Parameter übergeben wurden
    $googlePlacesId = env('GOOGLE_PLACE_ID');
    $apiKey = env('GOOGLE_API_KEY');

    // Führen Sie die Anfrage an die Google Places API aus
    $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
        'placeid' => $googlePlacesId,
        'fields' => 'name,place_id,reviews',
        'key' => $apiKey,
        'language' => 'de',
        'reviews_sort' => 'newest',
    ]);

    // Geben Sie die Antwort zurück
    return response()->json($response->json());
});

Route::get('/nav-links', [NavController::class, 'index'])->name('nav.index');
