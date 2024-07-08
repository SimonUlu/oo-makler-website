<?php

namespace App\Http\Controllers;

use App\Enums\NumberWord;
use App\Helpers\Estates\EnergyScale;
use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use Statamic\Facades\Collection;
use Statamic\Facades\GlobalSet;
use Statamic\View\View;

class EstateController extends Controller
{
    public function index()
    {
        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatelist')->get();
        $data = $collectionEntries->get(0);
        // if estateFields not in session, get them from the collection
        if (! request()->session()->has('estateFieldsFull')) {
            $estateFields = $data->get('estate_fields');
            request()->session()->put('estateFieldsFull', $estateFields);
        } else {
            $estateFields = EstateHelper::getEstateFields();
        }

        return (new View)
            ->template('estates.index')
            ->layout('layouts.layoutblade')
            ->with([
                'header_image' => $data['header_image'][0] ?? null,
                'before_title' => $data['before_title'] ?? null,
                'after_title' => $data['after_title'] ?? null,
                'title' => 'Immobilien',
                'estateFields' => $estateFields,
            ]);
    }

    public function show($estateId)
    {

        if (! is_numeric($estateId)) {
            // return page not found view
            return self::estateNotFound();
        }

        $estate = EstateEntryService::getEstateEntry($estateId);

        $epassSkalaImage = null;

        if ($estate !== null) {
            foreach ($estate->get('estate_images') ?? [] as $image) {
                if ($image['type'] === 'Epass_Skala') {
                    $epassSkalaImage = $image;
                    break;
                }
            }
        }

        if (empty($estate)) {
            // return page not found view
            return self::estateNotFound();
        }

        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatedetail')->get();
        // get the header_image_appearance from the global
        $collectionData = $collectionEntries->get(0);
        // get the iframe if present
        $showIframe = $collectionData->get('iframe_show') ?? null;
        $iframeTitle = $collectionData->get('iframe_title') ?? null;
        $iframe = $collectionData->get('iframe')['code'] ?? null;

        // get estate recommendations
        if ($estate->get('veroeffentlichen') == 'kauf') {
            $estateRecommendations = EstateEntryService::getFilteredEstates(
                'estate_entries',
                ['vermarktungsart' => [
                    ['op' => 'IN', 'val' => 'kauf']]],
                4,
                'kaufpreis',
                'desc',
                1,
                true
            );
        } elseif ($estate->get('veroeffentlichen') == 'miete') {
            $estateRecommendations = EstateEntryService::getFilteredEstates(
                'estate_entries',
                ['vermarktungsart' => [
                    ['op' => 'IN', 'val' => 'miete']]],
                4,
                'kaufpreis',
                'desc',
                1,
                true
            );
        } else {
            $estateRecommendations = EstateEntryService::getFilteredEstates(
                'estate_entries',
                [],
                4,
                'kaufpreis',
                'desc',
                1,
                true
            );
        }

        // remove current estate from recommendations
        $estateRecommendations = $estateRecommendations->reject(function ($value, $key) use ($estateId) {
            return (int) $value['id_internal'] == (int) $estateId;
        });

        $numItems = min(3, $estateRecommendations->count());
        $estateRecommendations = $estateRecommendations->random($numItems);

        // create energy scale from onOffice value
        $energyValue = $estate['endenergiebedarf'] ?? 0;
        $energyScale = new EnergyScale($energyValue, '');

        $anzahlZimmerWort = $this->numberToWord($estate['anzahl_zimmer']);

        $titelbild = '';

        // Get title image
        if (! empty($estate['estate_images'])) {
            foreach ($estate['estate_images'] as $image) {
                if ($image['type'] === 'Titelbild') {
                    $titelbild = $image['url'];
                    break;
                }
            }
            if (empty($titelbild)) {
                $titelbild = $estate['estate_images'][0]['url'];
            }
        }

        // get business hours from global set
        $businessInformation = [
            'business_hours' => GlobalSet::find('business_hours')->in('default')->get('dates'),
            'business_name' => GlobalSet::find('business_information')->in('default')->get('company_name'),
            'business_street' => GlobalSet::find('business_information')->in('default')->get('company_street'),
            'business_house_number' => GlobalSet::find('business_information')->in('default')->get('company_house_number'),
            'business_zip_code' => GlobalSet::find('business_information')->in('default')->get('company_zip'),
            'business_email' => GlobalSet::find('business_information')->in('default')->get('company_email'),
            'business_phone' => GlobalSet::find('business_information')->in('default')->get('company_phone'),
            'business_description' => GlobalSet::find('business_information')->in('default')->get('company_description'),
        ];

        // return view
        return (new View)
            ->template('estates.show')
            ->layout('layouts.layoutblade')
            ->with([
                'title' => substr($estate['objekttitel'], 0, 10).'...',
                'estate' => $estate,
                'estateId' => $estate['id_internal'],
                'headerImageAppearance' => $collectionData->header_image_appearance,
                'estateFields' => EstateHelper::getEstateFields(),
                'estateRecommendations' => $estateRecommendations->toArray(),
                'epassSkalaImage' => $epassSkalaImage,
                'pfeilposition' => $energyScale->getPfeilPosition(),
                'anzahlZimmerWort' => $anzahlZimmerWort,
                'titelbild' => $titelbild,
                'showIframe' => $showIframe,
                'iframeTitle' => $iframeTitle,
                'iframe' => $iframe,
                'businessInformation' => $businessInformation,
            ]);
    }

    public function estateNotFound()
    {
        // Render the view
        $view = View::make('errors.404-estate')
            ->with([
                'title' => '😳',
                'title_sub' => 'Diese Immobile ist nicht mehr in der Vermarktung.',
                'cta_text' => 'Damit das in Zukunft nicht nochmal passiert, jetzt direkt Suchauftrag erstellen.',
                'cta_button_link' => '/suchauftrag',
                'cta_button_text' => 'Suchauftrag erstellen',
            ])
            ->render();

        // Return the response with a 410 status code
        return response($view, 410)
            ->header('Content-Type', 'text/html');
    }

    public function numberToWord($number)
    {
        return NumberWord::fromNumber(round($number));
    }

    public function getAllEstates()
    {
        $estates = Collection::find('estate_entries')->queryEntries()->get();

        return response()->json($estates);
    }
}
