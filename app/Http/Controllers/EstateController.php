<?php

namespace App\Http\Controllers;

use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Illuminate\Http\Request;
use Statamic\Facades\Collection;
use Statamic\Facades\GlobalSet;
use Statamic\View\View;

class EstateController extends Controller
{
    public function index(Request $request, OnOfficeService $onOfficeService)
    {
        // get filter from query paramter
        $filters = EstateHelper::getFilterFromRequest($request);

        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatelist')->get();

        // Map over the entries to return the data properties of each
        $collectionData = $collectionEntries->map(function ($entry) {
            return $entry->data()->all();
        });

        $estateLocations = EstateEntryService::getLocationsOfAllEstates();

        return (new View)
            ->template('estates.index')
            ->layout('layouts.layoutblade')
            ->with([
                'header_image' => $collectionData[0]['header_image'][0] ?? null,
                'before_title' => $collectionData[0]['before_title'] ?? null,
                'onOfficeService' => $onOfficeService,
                'title' => 'Immobilien',
                'after_title' => $collectionData[0]['after_title'] ?? null,
                'listAppearance' => GlobalSet::find('estate_appearance_configuration')->in('default')->get('listappearance') ?? 'list',
                'estateLocations' => $estateLocations,
                'estateFields' => EstateHelper::getEstateFields($request, $onOfficeService),
                'filters' => $filters,
                'estateSource' => 'Entries',
            ]);
    }

    public function show(OnOfficeService $onOfficeService, $estateId)
    {

        if (! is_numeric($estateId)) {
            // return page not found view
            return self::estateNotFound();
        }

        $estate = $onOfficeService->getEstateById($estateId);

        if (empty($estate) || $estate['elements']['veroeffentlichen'] == '0' || $estate['elements']['referenz'] == '1') {
            // return page not found view
            return self::estateNotFound();
        }

        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatedetail')->get();

        // Map over the entries to return the data properties of each
        $collectionData = $collectionEntries->map(function ($entry) {
            return $entry->data()->all();
        });

        // get onOffice user information
        $onOfficeUser = $onOfficeService->getOnOfficeUserById((int) $estate['elements']['benutzer']);

        // get estate recommendations
        $estateRecommendations = EstateHelper::getEstatesWithImages(request(), $onOfficeService, []);
        // remove current estate from recommendations
        $estateRecommendations = collect($estateRecommendations)->reject(function ($value, $key) use ($estateId) {
            return (int) $value['id'] == (int) $estateId;
        });

        $numItems = min(3, collect($estateRecommendations)->count());
        $estateRecommendations = collect($estateRecommendations)->random($numItems);

        // return view
        return (new View)
            ->template('estates.show')
            ->layout('layouts.layoutblade')
            ->with([
                'title' => substr($estate['elements']['objekttitel'], 0, 10).'...',
                'estate' => $estate,
                'estateId' => $estate['id'],
                'headerImageAppearance' => $collectionData[0]['header_image_appearance'],
                'onOfficeUser' => $onOfficeUser,
                'estateRecommendations' => $estateRecommendations->toArray(),
            ]);
    }

    public function estateNotFound()
    {
        return (new View)
            ->template('errors.404-estate')
            ->layout('layouts.layoutblade')
            ->with(
                [
                    'title' => '😳',
                    'title_sub' => 'Diese Immobile ist nicht mehr in der Vermarktung.',
                    'cta_text' => 'Damit das in Zukunft nicht nochmal passiert, jetzt direkt Suchauftrag erstellen.',
                    'cta_button_link' => '/suchauftrag',
                    'cta_button_text' => 'Suchauftrag erstellen',
                ]
            );
    }
}
