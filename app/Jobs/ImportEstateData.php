<?php

namespace App\Jobs;

use App\Models\Estate;
use App\Models\EstateImage;
use App\Services\OnOfficeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportEstateData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Instanz Ihres OnOfficeService erstellen
        $onOfficeService = new OnOfficeService();

        // Definieren Sie Ihre Filter und Limit
        $filters = []; // Hier Ihre Filterlogik
        $limit = 500; // Beispielwert für das Limit

        // Abrufen der Immobilien
        $estates = $onOfficeService->getEstatesWithImages($filters, 0, $limit);
        $externalIds = collect($estates)->pluck('id');

        foreach ($estates as $estate) {
            // Create or update estate with newly found data
            $estateModel = Estate::updateOrCreate(
                ['external_id' => $estate['id']],
                [
                    'type' => $estate['type'],
                    'breitengrad' => $estate['elements']['breitengrad'], // Geändert von 'latitude'
                    'laengengrad' => $estate['elements']['laengengrad'], // Geändert von 'longitude'
                    'kaufpreis' => $estate['elements']['kaufpreis'], // Geändert von 'price'
                    'verkauft' => $estate['elements']['verkauft'],
                    'reserviert' => $estate['elements']['reserviert'],
                    'exclusive' => $estate['elements']['exclusive'],
                    'neu' => $estate['elements']['neu'],
                    'top_angebot' => $estate['elements']['top_angebot'],
                    'preisreduktion' => $estate['elements']['preisreduktion'],
                    'courtage_frei' => $estate['elements']['courtage_frei'],
                    'objekt_des_tages' => $estate['elements']['objekt_des_tages'],
                    'objekttitel' => $estate['elements']['objekttitel'], // Geändert von 'title'
                    'wohnflaeche' => $estate['elements']['wohnflaeche'], // Geändert von 'living_area'
                    'vermarktungsart' => $estate['elements']['vermarktungsart'], // Geändert von 'marketing_type'
                    'plz' => $estate['elements']['plz'], // Geändert von 'postal_code'
                    'ort' => $estate['elements']['ort'], // Geändert von 'city'
                    'objektart' => $estate['elements']['objektart'], // Geändert von 'estate_type'
                    'baujahr' => $estate['elements']['baujahr'], // Geändert von 'construction_year'
                    'anzahl_zimmer' => $estate['elements']['anzahl_zimmer'], // Geändert von 'rooms'
                    'warmmiete' => $estate['elements']['warmmiete'], // Geändert von 'warm_rent'
                    'veroeffentlichen' => $estate['elements']['veroeffentlichen'], // Geändert von 'publish'
                    'kaltmiete' => $estate['elements']['kaltmiete'], // Geändert von 'cold_rent'
                    'stammobjekt' => $estate['elements']['stammobjekt'], // Geändert von 'is_main_estate'
                    'status' => $estate['elements']['status'], // Geändert von 'status'
                    'objektbeschreibung' => $estate['elements']['objektbeschreibung'], // Geändert von 'description'
                    'etagen_zahl' => $estate['elements']['etagen_zahl'], // Geändert von 'floors'
                    'gesamtflaeche' => $estate['elements']['gesamtflaeche'], // Geändert von 'total_area'
                    'benutzer' => $estate['elements']['benutzer'], // Wenn dieses Feld existiert
                    'referenz' => $estate['elements']['referenz'], // Wenn dieses Feld existiert
                ]
            );

            $estateId = $estateModel->id;

            $imageUrls = [];

            // Create or update estate images
            foreach ($estate['elements']['images'] as $image) {
                $imageModel = EstateImage::updateOrCreate(
                    [
                        'estate_id' => $estateId,
                        'url' => $image['url'],
                    ],
                    [
                        'type' => $image['type'] ?? null,
                        'title' => $image['title'] ?? null,
                        'text' => $image['text'] ?? null,
                        'originalname' => $image['originalname'] ?? null,
                        'modified' => isset($image['modified']) ?? null,
                        'estateMainId' => $estateId,
                    ]
                );

                // Sammeln Sie die URLs der aktualisierten/erstellten Bilder
                $imageUrls[] = $imageModel->url;
            }

            // Löschen Sie alle Bilder, die nicht in den aktuellen Daten enthalten sind
            EstateImage::where('estate_id', $estateId)
                ->whereNotIn('url', $imageUrls)
                ->delete();
        }

        // Dann löschen Sie alle Estates, die nicht in den aktuellen Daten enthalten sind
        $deletedEstates = Estate::whereNotIn('external_id', $externalIds)->pluck('id');
        Estate::whereIn('id', $deletedEstates)->delete();

        // Schließlich löschen Sie alle EstateImages, die zu den gelöschten Estates gehören
        EstateImage::whereIn('estate_id', $deletedEstates)->delete();
    }
}
