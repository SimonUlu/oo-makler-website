<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('defaultFieldsEstate', function ($app) {
            return [
                'Id', 'objektnr_extern', 'benutzer', 'referenz', 'breitengrad', 'laengengrad', 'kaufpreis', 'lage',  'objekttitel', 'wohnflaeche', 'vermarktungsart', 'strasse', 'hausnummer',
                'plz', 'ort', 'objekttyp', 'objektart', 'baujahr', 'anzahl_zimmer', 'warmmiete', 'benutzer',  'objektbeschreibung', 'anzahl_badezimmer', 'geaendert_am',
                'anzahl_schlafzimmer', 'veroeffentlichen', 'kaltmiete', 'stammobjekt', 'status2', 'erstellt_am',
                'etagen_zahl', 'ausstatt_beschr', 'gesamtflaeche', 'energieausweistyp', 'energieverbrauchskennwert',
                'energieausweis_gueltig_bis', 'energietraeger', 'energyClass', 'energieausweisBaujahr', 'endenergiebedarf',
                'reserviert', 'verkauft', 'exclusive', 'neu', 'top_angebot', 'preisreduktion', 'courtage_frei', 'objekt_des_tages', 'status',
                'vermietet', 'kaltmiete', 'warmmiete', 'grundstuecksflaeche'
            ];
        });

        $this->app->singleton('performanceFieldEstates', function ($app) {
            return [
                'Id', 'benutzer', 'referenz', 'breitengrad', 'laengengrad', 'kaufpreis', 'objekttitel', 'wohnflaeche', 'vermarktungsart', 'geaendert_am', 'erstellt_am',
                'plz', 'ort', 'objektart', 'baujahr', 'anzahl_zimmer', 'warmmiete', 'veroeffentlichen', 'kaltmiete', 'stammobjekt', 'status', 'status2', 'objektbeschreibung', 'etagen_zahl', 'gesamtflaeche',
                'reserviert', 'verkauft', 'exclusive', 'neu', 'top_angebot', 'preisreduktion', 'courtage_frei', 'objekt_des_tages', 'status', 'endenergiebedarf',
                'vermietet', 'kaltmiete', 'warmmiete', 'grundstuecksflaeche'
            ];
        });

        $this->app->singleton('estateListFieldEstate', function ($app) {
            return [
                'Id', 'benutzer', 'breitengrad', 'laengengrad', 'kaufpreis', 'objekttitel', 'wohnflaeche', 'vermarktungsart', 'geaendert_am', 'erstellt_am',
                'plz', 'ort', 'objektart', 'baujahr', 'anzahl_zimmer', 'warmmiete', 'veroeffentlichen', 'kaltmiete', 'stammobjekt', 'status', 'status2', 'etagen_zahl', 'gesamtflaeche',
                'reserviert', 'verkauft', 'exclusive', 'neu', 'top_angebot', 'preisreduktion', 'courtage_frei', 'objekt_des_tages', 'estate_images', 'status', 'endenergiebedarf',
                'vermietet', 'kaltmiete', 'warmmiete', 'grundstuecksflaeche'
            ];
        });

        $this->app->singleton('defaultFieldsUser', function ($app) {
            return [
                'Vorname',
                'Nachname',
                'Name',
                'Nr',
                'email',
                'Telefon',
            ];
        });

        $this->app->singleton('defaultFilter', function ($app) {
            return [
                'veroeffentlichen' => [
                    ['op' => '=', 'val' => 1],
                ],
            ];
        });

        $this->app->singleton('defaultFieldsImages', function ($app) {
            return [
                'Titelbild',
                'Foto',
                'Foto_gross',
                'Panorama',
                'Grundriss',
                'Lageplan',
                'Epass_Skala',
                'Energiepass-Skala',
            ];
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
