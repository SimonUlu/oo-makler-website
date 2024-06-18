<?php

namespace App\Services\OnOffice\Requests\Read;

use App\Services\OnOffice\Requests\AbstractRequest;

class Estate extends AbstractRequest
{
    const COLUMNS = [
        'Id',
        'objektnr_extern',
        'nutzungsart',
        'objektart',
        'objekttyp',
        'vermarktungsart',
        // Geo
        'plz',
        'ort',
        'breitengrad',
        'laengengrad',
        'strasse',
        'hausnummer',
        'bundesland',
        'land',
        'gemeindecode',
        'flur',
        'flurstueck',
        'gemarkung',
        'etage',
        'lage_im_bau',
        'wohnungsnr',
        'lage_gebiet',
        'regionaler_zusatz',

        // Preise
        'kaltmiete',
        'nebenkosten',
        'warmmiete',
        'heizkosten',
        'kaufpreis',
        'kaufpreis_pro_qm',
        'kaufpreis_inkl_ust',
        'kaufpreis_exkl_ust',
        'freitext_preis',
        'innen_courtage',
        'aussen_courtage',
        'waehrung',
        'pacht',
        'erbpacht',
        'hausgeld',
        'abstand',
        'erschliessungskosten',
        'provisionsAbgabe',
        'provisionsAbgabe_innen',

        //        'stellplatzkaufpreis',
        //        'mwst_satz',
        //        'x_fache',
        //        'nettorendite',
        //        'mieteinnahmen_ist',
        //        'mieteinnahmen_soll',
        //        'kaution',
        //        'geschaeftsguthaben',
        //        'stellplatzmiete',
        //        'stp_anzahl',
        //        'zzgl_mehrwertsteuer',
        //        'mietzuschlaege',
        //        'preis_zeitraum_von',
        //        'preis_zeitraum_bis',
        //        'mietpreis_pro_qm',

        // Freitexte
        'objekttitel',
        'dreizeiler',
        'lage',
        'ausstatt_beschr',
        'objektbeschreibung',
        'sonstige_angaben',

        // Fläche
        'wohnflaeche',
        'nutzflaeche',
        'gesamtflaeche',
        'ladenflaeche',
        'lagerflaeche',
        'verkaufsflaeche',
        'freiflaeche',
        'bueroflaeche',
        'bueroteilflaeche',
        'fensterfront',
        'verwaltungsflaeche',
        'gastroflaeche',
        'grz',
        'gfz',
        'bmz',
        'bgf',
        'grundstuecksflaeche',
        'sonstflaeche',
        'anzahl_zimmer',
        'anzahl_schlafzimmer',
        'anzahl_badezimmer',
        'anzahl_sep_wc',
        'anzahl_wohn_schlafzimmer',
        'gartenflaeche',
        'kellerflaeche',
        'fensterfront_qm',
        'grundstuecksfront',
        'dachbodenflaeche',
        'teilbar_ab',
        'beheizbare_flaeche',
        'anzahl_stellplaetze',
        'plaetze_gastraum',
        'anzahl_betten',
        'anzahl_tagungsraeume',
        'vermietbare_flaeche',
        'anzahl_wohneinheiten',
        'anzahl_gewerbeeinheiten',

        // Ausstattung
        'wg_geeignet',
        'raeume_veraenderbar',
        'bad',
        'kueche',
        'boden',
        'kamin',
        'heizungsart',
        'befeuerung',
        'klimatisiert',
        'fahrstuhl',
        'stellplatzart',
        'gartennutzung',
        'ausricht_balkon_terrasse',
        'moebliert_old',
        'rollstuhlgerecht',
        'kabel_sat_tv',
        'barrierefrei',
        'sauna',
        'swimmingpool',
        'wasch_trockenraum',
        'dv_verkabelung',
        'rampe',
        'hebebuehne',
        'kran',
        'gastterrasse',
        'stromanschlusswert',
        'kantine_cafeteria',
        'teekueche',
        'angeschl_gastronomie',
        'brauereibindung',
        'sporteinrichtungen',
        'wellnessbereich',
        'serviceleistungen',
        'telefon_ferienimmobilie',
        'sicherheitstechnik',
        'unterkellertText',
        'etagen_zahl',
        'bodenbelastung',
        'balkon_terrasse',
        'max_krangewicht',
        'bahnanschluss',
        'toiletten',
        'wasseranschluss',
        'stromanschluss',
        'gasanschluss',
        'gartensitzplatz',
        'ruhig',
        'sonnig',
        'spielplatz',
        'gedeckt',
        'telefon_fax',
        'lastwagenladerampe',
        'max_warenlift',
        'isdn',
        'abwasseranschluss',
        'druckluft',
        'geschrirrspuelmaschine',
        'sep_waeschetrockner',
        'sep_waschmaschine',
        'herd',
        'stromanschl_art',
        'zentral',
        'strabgew',
        'unterkellert',
        'gaesteWc',
        'starkstrom',
        'moebliert',
        'abstellraum',
        'fahrradraum',
        'wohnungskategorie',
        'wintergarten',
        'multiParkingLot',
        'geaendert_am',
        'angebotsrecht',
    ];

    /**
     * Estates constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ACTION_ID_READ, 'estate');

        // defaults
        $this->setData(['Id']);
        $this->setLimit(100);
    }

    /**
     * @param  string[]  $data
     */
    public function setData(array $data): Estate
    {
        $this->parameters['data'] = $data;

        return $this;
    }

    public function setLimit(int $limit): Estate
    {
        $this->parameters['listlimit'] = $limit;

        return $this;
    }

    public function setOffset(int $offset): Estate
    {
        $this->parameters['listoffset'] = $offset;

        return $this;
    }

    public function setFilter(string $column, array $filter): Estate
    {
        $this->parameters['filter'][$column] = $filter;

        return $this;
    }

    public function setSortBy(string $column): Estate
    {
        $this->parameters['sortby'] = $column;

        return $this;
    }

    public function setSortOrder(string $order = 'ASC'): Estate
    {
        $this->parameters['sortorder'] = $order;

        return $this;
    }

    public function setRecordIds(array $recordIds): Estate
    {
        $this->parameters['recordids'] = $recordIds;

        return $this;
    }

    public function setResourceId($resourceId): Estate
    {
        // Call the parent's setResourceId method
        parent::setResourceId($resourceId);

        return $this;
    }
}
