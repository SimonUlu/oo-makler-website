<?php

namespace App\Console\Commands;

use App\Models\GeoData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; // Importiere den HTTP Client

//php artisan import:geodata https://statamic-template.inno-brain.de/georef-germany-postleitzahl.geojson

class ImportGeoJsonDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:geodata {url}';

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
            GeoData::create([
                'name' => $feature['properties']['name'],
                'plz_name' => $feature['properties']['plz_name'],
                'plz_name_long' => $feature['properties']['plz_name_long'],
                'plz_code' => $feature['properties']['plz_code'],
                'krs_code' => $feature['properties']['krs_code'],
                'lan_name' => $feature['properties']['lan_name'],
                'lan_code' => $feature['properties']['lan_code'],
                'krs_name' => $feature['properties']['krs_name'],
                'geo_point_2d' => $feature['properties']['geo_point_2d'],
                'geometry' => $feature['geometry'],
            ]);
        }

        $this->info('Data imported successfully!');
    }
}
