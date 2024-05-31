<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class DistrictViewModel extends ViewModel
{
    public function data(): array
    {
        // Pfad zur GeoJSON-Datei
        $geoJsonPath = public_path('geo/georef-germany-postleitzahl.geojson');

        // GeoJSON-Daten einlesen
        $geoJsonData = file_get_contents($geoJsonPath);

        // dd($geoJsonData);
        // Wandele die GeoJSON-Daten in einen JSON-String um
        $encodedGeoJson = json_encode($geoJsonData);

        $content = json_encode(collect($this->cascade->get('stadtteile')));
        // dd($content);

        // Rückgabe der Daten an das View
        return [
            'geoJsonData' => $encodedGeoJson,
            'stadtteile_json' => $content,
        ];
    }
}
