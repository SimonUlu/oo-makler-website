<?php

namespace App\Console\Commands;

use App\Models\GeoArea;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; // Importiere den HTTP Client

class ImportGeoAreaDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:geoarea {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import geodata from a GeoJSON file located at a given URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');

        // Verwende den HTTP Client von Laravel, um die Daten zu bekommen
        $response = Http::withBasicAuth('innobrain', 'innobrain')->get($url);

        if (! $response->successful()) {
            $this->error('Failed to fetch data from URL.');

            return;
        }

        $data = json_decode($response->body(), true);

        foreach ($data['features'] as $feature) {
            GeoArea::create([
                'Year' => $feature['properties']['year'],
                'Kreis_code' => $feature['properties']['krs_code'][0],
                'Kreis_name' => $feature['properties']['krs_name'][0],
                'Kreis_name_short' => $feature['properties']['krs_name_short'][0],
                'Type' => 'Geocode',
                'Land_code' => $feature['properties']['lan_code'][0],
                'Land_name' => $feature['properties']['lan_name'][0],
                'ISO_3166_3_Area_code' => $feature['properties']['krs_area_code'],
                'geometry' => $feature['geometry'],
            ]);
        }

        $this->info('Data imported successfully!');
    }
}
// https://statamic-template.inno-brain.de/georef-germany-kreis.geojson
