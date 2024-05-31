<?php

namespace App\Services\EstateHandlers;

use App\Contracts\EstateServiceInterface;
use App\Models\Estate;
use Illuminate\Pipeline\Pipeline;

class EstateService implements EstateServiceInterface
{
    // In Ihrem Controller oder Service-File
    public function getEstatesForMap($filter)
    {

        $query = Estate::with('images');

        if (! empty($filter['kaufpreis__von'])) {
            $query->where('kaufpreis', '>=', $filter['kaufpreis__von']);
        }

        if (! empty($filter['kaufpreis__bis'])) {
            $query->where('kaufpreis', '<=', $filter['kaufpreis__bis']);
        }

        if (! empty($filter['anzahl_zimmer__von'])) {
            $query->where('anzahl_zimmer', '>=', $filter['anzahl_zimmer__von']);
        }

        if (! empty($filter['anzahl_zimmer__bis'])) {
            $query->where('anzahl_zimmer', '<=', $filter['anzahl_zimmer__bis']);
        }

        if (! empty($filter['ort'])) {
            $query->whereIn('ort', $filter['ort']);
        }

        if (! empty($filter['vermarktungsart'])) {
            $query->whereIn('vermarktungsart', $filter['vermarktungsart']);
        }

        if (! empty($filter['objektart'])) {
            $query->whereIn('objektart', $filter['objektart']);
        }

        $estates = $query->get();

        $estates = $estates->map(function ($estate) {
            return [
                'id' => $estate->external_id,
                'type' => 'estate',
                'elements' => [
                    'Id' => $estate->external_id,
                    'breitengrad' => $estate->breitengrad,
                    'laengengrad' => $estate->laengengrad,
                    'kaufpreis' => $estate->kaufpreis,
                    'objekttitel' => $estate->objekttitel,
                    'objektnr_extern' => $estate->objektnr_extern,
                    'wohnflaeche' => $estate->wohnflaeche,
                    'vermarktungsart' => $estate->vermarktungsart,
                    'plz' => $estate->plz,
                    'ort' => $estate->ort,
                    'objektart' => $estate->objektart,
                    'baujahr' => $estate->baujahr,
                    'anzahl_zimmer' => $estate->anzahl_zimmer,
                    'warmmiete' => $estate->warmmiete,
                    'veroeffentlichen' => $estate->veroeffentlichen,
                    'kaltmiete' => $estate->kaltmiete,
                    'stammobjekt' => $estate->stammobjekt,
                    'status' => $estate->status,
                    'objektbeschreibung' => $estate->objektbeschreibung,
                    'etagen_zahl' => $estate->etagen_zahl,
                    'gesamtflaeche' => $estate->gesamtflaeche,
                    'benutzer' => $estate->benutzer, // Stellen Sie sicher, dass dieses Feld im Modell existiert
                    'referenz' => $estate->referenz, //
                    // Bilder als Array von Bild-Details
                    'images' => $estate->images->map(function ($image) {
                        return [
                            'url' => $image->url,
                            'title' => $image->title,
                            'description' => $image->description,
                            'original_name' => $image->original_name,
                            'modified' => $image->modified,
                        ];
                    }),
                ],
            ];
        });

        // Geben Sie nun den Paginator zurück, der die transformierten Daten enthält
        return $estates;
    }

    // In Ihrem Controller oder Service-File

    public function getEstatesWithImages($filter, $perPage = 10, $sortField = 'kaufpreis', $sortDirection = 'asc', $page = 1)
    {

        // send estates through filter & sort pipeline
        $estatesQuery = app(Pipeline::class)
            ->send(Estate::query())
            ->through([
                new \App\Pipes\FilterEstates($filter),
                \App\Pipes\SortEstates::withParameters($sortField, $sortDirection),
            ])
            ->thenReturn();

        $paginator = $estatesQuery->paginate($perPage)->through(function ($estate) {
            return [
                'id' => $estate->external_id,
                'type' => 'estate',
                'elements' => [
                    'Id' => $estate->external_id,
                    'breitengrad' => $estate->breitengrad,
                    'laengengrad' => $estate->laengengrad,
                    'kaufpreis' => $estate->kaufpreis,
                    'objekttitel' => $estate->objekttitel,
                    'objektnr_extern' => $estate->objektnr_extern,
                    'wohnflaeche' => $estate->wohnflaeche,
                    'vermarktungsart' => $estate->vermarktungsart,
                    'plz' => $estate->plz,
                    'ort' => $estate->ort,
                    'objektart' => $estate->objektart,
                    'baujahr' => $estate->baujahr,
                    'anzahl_zimmer' => $estate->anzahl_zimmer,
                    'warmmiete' => $estate->warmmiete,
                    'veroeffentlichen' => $estate->veroeffentlichen,
                    'kaltmiete' => $estate->kaltmiete,
                    'stammobjekt' => $estate->stammobjekt,
                    'status' => $estate->status,
                    'objektbeschreibung' => $estate->objektbeschreibung,
                    'etagen_zahl' => $estate->etagen_zahl,
                    'gesamtflaeche' => $estate->gesamtflaeche,
                    'benutzer' => $estate->benutzer,
                    'referenz' => $estate->referenz, //
                    // Bilder als Array von Bild-Details
                    'images' => $estate->images->map(function ($image) {
                        return [
                            'url' => $image->url,
                            'title' => $image->title,
                            'description' => $image->description,
                            'original_name' => $image->original_name,
                            'modified' => $image->modified,
                        ];
                    }),
                ],
            ];
        });

        return $paginator;
    }

    public static function getLocationsOfAllEstates()
    {
        $estateLocations = Estate::getUniqueLocations();

        return $estateLocations;
    }

    public static function getEstatesUnpaginated($filter, $perPage, $sortField = 'kaufpreis', $sortDirection = 'asc')
    {
        return 'Hallo';
    }
}
