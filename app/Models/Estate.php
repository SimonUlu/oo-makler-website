<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = [
        'external_id',
        'type',
        'breitengrad', // Geändert von 'latitude'
        'laengengrad', // Geändert von 'longitude'
        'kaufpreis', // Geändert von 'price'
        'objekttitel', // Geändert von 'title'
        'objektnr_extern',
        'wohnflaeche', // Geändert von 'living_area'
        'vermarktungsart', // Geändert von 'marketing_type'
        'plz', // Geändert von 'postal_code'
        'ort', // Geändert von 'city'
        'objektart', // Geändert von 'estate_type'
        'baujahr', // Geändert von 'construction_year'
        'anzahl_zimmer', // Geändert von 'rooms'
        'warmmiete', // Geändert von 'warm_rent'
        'veroeffentlichen', // Geändert von 'publish'
        'kaltmiete', // Geändert von 'cold_rent'
        'stammobjekt', // Geändert von 'is_main_estate'
        'status', // Geändert von 'status'
        'objektbeschreibung', // Geändert von 'description'
        'etagen_zahl', // Geändert von 'floors'
        'gesamtflaeche', // Geändert von 'total_area'
        'benutzer', // Wenn dieses Feld in der Tabelle existiert
        'referenz', // Wenn dieses Feld in der Tabelle existiert
        // Fügen Sie hier weitere Felder hinzu, die Sie speichern möchten
    ];

    public function images()
    {
        return $this->hasMany(EstateImage::class, 'estateid');
    }

    public static function getUniqueLocations()
    {
        return self::distinct('ort')->pluck('ort')->toArray();
    }
}
