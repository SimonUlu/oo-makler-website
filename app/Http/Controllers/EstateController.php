<?php

namespace App\Http\Controllers;

use App\Enums\NumberWord;
use App\Helpers\Estates\EnergyScale;
use App\Services\EstateHandlers\EstateEntryService;
use App\Services\OnOfficeService;
use Statamic\Facades\Collection;
use Statamic\View\View;

class EstateController extends Controller
{
    public function index()
    {
        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatelist')->get();
        $data = $collectionEntries->get(0);

        return (new View)
            ->template('estates.index')
            ->layout('layouts.layoutblade')
            ->with([
                'header_image' => $data['header_image'][0] ?? null,
                'before_title' => $data['before_title'] ?? null,
                'after_title' => $data['after_title'] ?? null,
                'title' => 'Immobilien',
            ]);
    }

    public function show(OnOfficeService $onOfficeService, $estateId)
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

        if (empty($estate) || $estate->get('veroeffentlichen') == '0' || $estate->get('referenz') == '1') {
            // return page not found view
            return self::estateNotFound();
        }

        // Fetch the Collection
        $collectionEntries = Collection::findByHandle('estates')->queryEntries()->where('blueprint', 'estatedetail')->get();
        // get the header_image_appearance from the global
        $collectionData = $collectionEntries->get(0);

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

        // return view
        return (new View)
            ->template('estates.show')
            ->layout('layouts.layoutblade')
            ->with([
                'title' => substr($estate['objekttitel'], 0, 10).'...',
                'estate' => $estate,
                'estateId' => $estate['id_internal'],
                'headerImageAppearance' => $collectionData->header_image_appearance,
                'estateFields' => request()->session()->get('estateFieldsFull'),
                'estateRecommendations' => $estateRecommendations->toArray(),
                'epassSkalaImage' => $epassSkalaImage,
                'pfeilposition' => $energyScale->getPfeilPosition(),
                'anzahlZimmerWort' => $anzahlZimmerWort,
                'titelbild' => $titelbild,
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
