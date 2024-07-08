<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportGeoJsonDataFile extends Command
{
    protected $signature = 'import:geo-data {file}';

    protected $description = 'Import geo data from a GeoJSON file into a Statamic collection';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $file = $this->argument('file');

        if (! File::exists($file)) {
            $this->error("File not found: $file");

            return;
        }

        $json = File::get($file);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Invalid JSON file: $file");

            return;
        }

        if (! isset($data['features'])) {
            $this->error("Invalid GeoJSON structure: 'features' key not found.");

            return;
        }

        $chunkSize = 100; // Number of features to process at a time
        $chunks = array_chunk($data['features'], $chunkSize);

        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $feature) {
                $properties = $feature['properties'];
                $geometry = $feature['geometry'];

                $insertData[] = [
                    'name' => $properties['name'],
                    'plz_name' => $properties['plz_name'],
                    'plz_name_long' => $properties['plz_name_long'],
                    'plz_code' => $properties['plz_code'],
                    'krs_code' => $properties['krs_code'],
                    'lan_name' => $properties['lan_name'],
                    'lan_code' => $properties['lan_code'],
                    'krs_name' => $properties['krs_name'],
                    'geo_point_2d' => json_encode([
                        'lon' => $properties['geo_point_2d']['lon'],
                        'lat' => $properties['geo_point_2d']['lat'],
                    ]),
                    'geometry' => json_encode($geometry),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('geo_data')->insert($insertData);

            // Clear memory after processing each chunk
            unset($chunk);
            gc_collect_cycles();
        }

        $this->info('Geo data imported successfully.');

    }
}
