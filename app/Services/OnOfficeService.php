<?php

namespace App\Services;

use App\Helpers\Estates\UserDetails;
use App\Http\Controllers\SessionController;
use App\Services\OnOfficeApiHandlerService\CreateHandler;
use App\Services\OnOfficeApiHandlerService\GetHandler;
use App\Services\OnOfficeApiHandlerService\ModifyHandler;
use App\Services\OnOfficeApiHandlerService\ReadHandler;
use App\Services\OnOfficeApiService\Api;
use Exception;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class OnOfficeService
{
    protected Api $api;

    protected array $estateFields;

    private array $defaultFieldsEstate = [
        'Id', 'objektnr_extern', 'benutzer', 'referenz', 'breitengrad', 'laengengrad', 'kaufpreis', 'lage',  'objekttitel', 'wohnflaeche', 'vermarktungsart', 'strasse', 'hausnummer',
        'plz', 'ort', 'objekttyp', 'objektart', 'baujahr', 'anzahl_zimmer', 'warmmiete', 'benutzer',  'objektbeschreibung', 'anzahl_badezimmer', 'geaendert_am',
        'anzahl_schlafzimmer', 'veroeffentlichen', 'kaltmiete', 'stammobjekt', 'status2', 'erstellt_am',
        'etagen_zahl', 'ausstatt_beschr', 'gesamtflaeche', 'energieausweistyp', 'energieverbrauchskennwert',
        'energieausweis_gueltig_bis', 'energietraeger', 'energyClass', 'energieausweisBaujahr', 'endenergiebedarf',
        'reserviert', 'verkauft', 'exclusive', 'neu', 'top_angebot', 'preisreduktion', 'courtage_frei', 'objekt_des_tages',
    ];

    private array $performanceFieldEstates = [
        'Id', 'benutzer', 'referenz', 'breitengrad', 'laengengrad', 'kaufpreis', 'objekttitel', 'wohnflaeche', 'vermarktungsart', 'geaendert_am', 'erstellt_am',
        'plz', 'ort', 'objektart', 'baujahr', 'anzahl_zimmer', 'warmmiete', 'veroeffentlichen', 'kaltmiete', 'stammobjekt', 'status', 'status2', 'objektbeschreibung', 'etagen_zahl', 'gesamtflaeche',
        'reserviert', 'verkauft', 'exclusive', 'neu', 'top_angebot', 'preisreduktion', 'courtage_frei', 'objekt_des_tages',
    ];

    private array $defaultFieldsUser = [
        'Vorname',
        'Nachname',
        'Name',
        'Nr',
        'email',
        'Telefon',
    ];

    private array $defaultFilter = [
        'veroeffentlichen' => [
            ['op' => '=', 'val' => 1],
        ],
    ];

    public function __construct()
    {
        $globalSet = GlobalSet::find('onoffice')->in('default');

        $token = $globalSet->get('onoffice_token');
        $secret = $globalSet->get('onoffice_secret');

        if (empty($token) || empty($secret)) {
            throw new Exception('Onoffice token or secret parameters missing');
        }

        $this->api = new Api(
            $token,
            $secret
        );

        $this->estateFields =
            array_values(
                array_unique(
                    array_filter(
                        array_merge(
                            SessionController::getFilterOptionFields(),
                            SessionController::getFieldListFromCp(),
                            $this->defaultFieldsEstate
                        )
                    )
                )
            );
    }

    public function read(): ReadHandler
    {
        return new ReadHandler($this->api);
    }

    public function create(): CreateHandler
    {
        return new CreateHandler($this->api);
    }

    public function modify(): ModifyHandler
    {
        return new ModifyHandler($this->api);
    }

    public function get(): GetHandler
    {
        return new GetHandler($this->api);
    }

    public function getStatistics($statisticIdentifier): ?array
    {
        $getCntAbsolute = false;

        if (empty($statisticIdentifier)) {
            return null;
        }

        $statisticData = GlobalSet::find('onoffice')->in('default')->get('statistics_replicator');

        if (empty($statisticData)) {
            return null;
        }

        $statisticData = collect($statisticData)->where('statistic_identifier', $statisticIdentifier)->first();

        if (empty($statisticData)) {
            return null;
        }

        $filters = $this->transformFilterArray($statisticData);

        if (! empty($statisticData['added_time_filter']) && ! empty($statisticData['field_for_added_time_filter'])) {
            // Initialize variables
            $timeSpan = null;
            $operator = null;

            // Determine the time filter and operator
            switch ($statisticData['added_time_filter']) {
                case 'year_over_year':
                    $timeSpan = date('Y-m-d H:i:s', \Safe\strtotime('-1 year'));
                    $operator = '>=';
                    break;

                case 'year_to_date':
                    $timeSpan = date('Y-01-01 00:00:00');
                    $operator = '>=';
                    break;

                case 'past_year':
                    $timeSpan = date('Y-m-d H:i:s', \Safe\strtotime('-1 year'));
                    $operator = '<=';
                    break;

                case 'future':
                    $timeSpan = date('Y-m-d H:i:s', \Safe\strtotime('+1 year'));
                    $operator = '>';
                    break;

                default:
                    // Handle unexpected filter types if needed
                    break;
            }

            // Add the filter if timeSpan and operator are set
            if ($timeSpan !== null && $operator !== null) {
                $filters = array_merge(
                    $filters,
                    [
                        $statisticData['field_for_added_time_filter'] => [
                            ['op' => $operator, 'val' => $timeSpan],
                        ],
                    ]
                );
            }
        }

        // get added filter

        $aggregationFunction = $statisticData['aggregation_function'] ?? 'count';
        $fieldForAggregation = $statisticData['field_for_aggregation_function'] ?? 'Id';

        // if aggregation function is count, set $getCntAbsolute to true
        if ($aggregationFunction === 'count') {
            $getCntAbsolute = true;
        }

        $results = $this->read()->get(
            data: [$fieldForAggregation],
            module: $statisticData['statistic_module'],
            filters: $filters,
            getCntAbsolute: $getCntAbsolute
        );

        if (empty($results)) {
            return null;
        }

        if ($getCntAbsolute) {
            return [
                'statistic_value' => $results['data']['meta']['cntabsolute'],
                'title' => $statisticIdentifier,
                'date_last_sync' => now()->setTimezone('Europe/Berlin')->format('Y-m-d H:i:s'),
            ];
        }

        $values = array_map(function ($result) use ($fieldForAggregation) {
            return $result['elements'][$fieldForAggregation] ?? null;
        }, $results['data']['records']);

        $values = array_filter($values);

        // get the statistic based on the aggregation function
        $statistic = match ($aggregationFunction) {
            'sum' => array_sum($values),
            'average' => array_sum($values) / count($values),
            'min' => min($values),
            'max' => max($values),
            default => null,
        };

        return [
            'statistic_value' => $statistic,
            'title' => $statisticIdentifier,
            'date_last_sync' => now()->setTimezone('Europe/Berlin')->format('Y-m-d H:i:s'),
        ];
    }

    public static function transformFilterArray($array): array
    {
        $filters = [];

        if (isset($array['replicator_field_filter']) && is_array($array['replicator_field_filter'])) {
            foreach ($array['replicator_field_filter'] as $filter) {
                if (isset($filter['array_filter'])) {
                    $labelId = $filter['array_filter']['label_id'] ?? null;
                    $operator = $filter['array_filter']['operator'] ?? null;
                    $value = $filter['array_filter']['value'] ?? null;

                    if ($labelId && $operator && $value !== null) {
                        if (in_array(strtolower($operator), ['in', 'not in'])) {
                            $value = explode(',', $value);
                        }
                        $filters[$labelId] = [
                            ['op' => $operator, 'val' => $value],
                        ];
                    }
                }
            }
        }

        return $filters;
    }

    // added specific users
    public function getEstatesWithImages($filters = [], $page = 0, $perPage = 15)
    {
        $result = $this->read()->get(
            data: $this->performanceFieldEstates,
            module: 'estate',
            filters: array_merge($filters, $this->defaultFilter),
            offset: $page * $perPage,
            limit: $perPage
        )['data']['records'] ?? [];

        if (! empty($result)) {
            $estateIds = array_map(function ($item) {
                return $item['id'];
            }, $result);
            $images = self::getEstateImagesByIds($estateIds, ['Titelbild', 'Foto', 'Foto_gross', 'Panorama', 'Grundriss']);
            foreach ($result as $key => $estate) {
                $result[$key]['elements']['images'] = collect($images)->where('estateId', $estate['id'])->first()['elements'] ?? [];
            }
        }

        return $result ?? [];
    }

    public function getEstatesWithFloorImages($filters = [], $page = 0, $perPage = 15)
    {
        $result = $this->read()->get(
            data: $this->performanceFieldEstates,
            module: 'estate',
            filters: array_merge($filters, $this->defaultFilter),
            offset: $page * $perPage,
            limit: $perPage
        )['data']['records'] ?? [];
        if (! empty($result)) {
            $estateIds = array_map(function ($item) {
                return $item['id'];
            }, $result);
            $images = self::getEstateImagesByIds($estateIds, ['Grundriss']);
            foreach ($result as $key => $estate) {
                $result[$key]['elements']['images'] = collect($images)->where('estateId', $estate['id'])->first()['elements'] ?? [];
            }
        }

        return $result ?? [];
    }

    public function getEstateById($estateId)
    {
        $result = $this->read()->get(
            data: $this->estateFields,
            module: 'estate',
            filters: $this->defaultFilter,
            resourceId: $estateId
        )['data']['records'][0] ?? [];

        if (! empty($result)) {
            $images = self::getEstateImagesByIds([$result['id']], ['Titelbild', 'Foto', 'Foto_gross', 'Panorama', 'Grundriss', 'Lageplan', 'Epass_Skala', 'Energiepass-Skala']);
            $result['elements']['images'] = $images[0]['elements'] ?? [];
        }

        return $result ?? [];
    }

    public function getAllEstateFields()
    {
        $result = $this->get()->getFieldConfiguration(
            module: 'estate',
        )['data']['records'] ?? [];

        $result = collect($result)->where('id', 'estate')->first()['elements'] ?? [];
        // if first key is 'label' remove it
        if (array_key_first($result) === 'label') {
            unset($result['label']);
        }

        return $result ?? [];
    }

    public function getEstateImagesByIds(array $estateIds, ?array $categories, $language = 'DEU'): array
    {
        // if estateCategories are not set, get all images
        if (! $categories) {
            $categories = ['Titelbild', 'Foto', 'Foto_gross', 'Panorama', 'Grundriss', 'Energiepass-Skala'];
        }
        try {
            $results = $this->get()->getImagesFromEstates(
                estateIds: $estateIds,
                categories: $categories,
                language: $language,
            )['data']['records'] ?? [];
        } catch (Exception $e) {
            error_log($e);
        }

        $collection = collect($results);

        $grouped = $collection->groupBy(function ($item) {
            return $item['elements'][0]['estateid'];
        });

        $elements = [];

        foreach ($grouped as $estateId => $items) {
            $elements[] = [
                'estateId' => $estateId,
                'elements' => $items->flatMap(function ($item) {
                    return $item['elements'];
                })->values()->toArray(),
            ];
        }

        return $elements;
    }

    public function getSubEstates($estateIds): array
    {

        return $this->get()->relations(
            'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:estateUnit',
            $estateIds,
        );
    }

    public function getEstatesWithImagesExtended($filters = [], $page = 0, $perPage = 15)
    {
        $result = $this->read()->get(
            data: $this->defaultFieldsEstate,
            module: 'estate',
            filters: array_merge($filters, $this->defaultFilter),
            offset: $page * $perPage,
            limit: $perPage
        )['data']['records'] ?? [];

        if (! empty($result)) {
            $estateIds = array_map(function ($item) {
                return $item['id'];
            }, $result);

            // Aufteilen der estateIds in Gruppen von maximal 49 IDs
            $chunks = array_chunk($estateIds, 49);
            $images = [];

            foreach ($chunks as $chunk) {
                try {
                    // Führe für jede Gruppe die getEstateImagesByIds-Methode aus
                    $chunkImages = self::getEstateImagesByIds($chunk, ['Titelbild', 'Foto', 'Foto_gross', 'Panorama', 'Grundriss']);
                    // Füge die Ergebnisse zusammen
                    $images = array_merge($images, $chunkImages);
                } catch (Exception $e) {
                    error_log($e);
                }
            }
            foreach ($result as $key => $estate) {
                $result[$key]['elements']['images'] = collect($images)->where('estateId', $estate['id'])->first()['elements'] ?? [];
            }
        }

        return $result ?? [];
    }

    public function getOnOfficeUserById(int $userId): UserDetails
    {
        $user = Entry::query()->where('collection', 'on_office_users')
            ->where('Nr', $userId)
            ->get();

        $photo = $this->getUserPhotoById($userId);

        return $this->createUserDetailsFromData($user->all(), $photo);
    }

    protected function createUserDetailsFromData(array $user = [], array $photo): UserDetails
    {
        if ($user && isset($user['elements']['Vorname']) && isset($user['elements']['Nachname'])) {
            $vorname = $user['elements']['Vorname'];
            $nachname = $user['elements']['Nachname'];
            $email = $user['elements']['email'];
            $picUrl = $photo['elements']['photo'] ?? '';
            $phoneNumber = $user['elements']['Telefon'];

            return new UserDetails($vorname, $nachname, $email, $picUrl, $phoneNumber);
        } else {
            return new UserDetails();
        }
    }

    public function getUserPhotoById($userId = null)
    {
        $filter = [
            'Nr' => [
                ['op' => '=', 'val' => $userId],
            ],
        ];

        return $this->read()->userPhoto(
            filter: $filter,
        )['data']['records'][0] ?? [];
    }

    public static function removeFieldsFromEstate($estates)
    {
        return $estates->map(function ($estate) {
            // Get the necessary fields directly from the data collection
            $filteredData = $estate->data()->only(app('estateListFieldEstate'));

            // Add the 'id_internal' field to the filtered data
            $filteredData['id_internal'] = $estate->get('id_internal');

            // If 'estate_images' field exists, get only the first three values
            if (isset($filteredData['estate_images']) && is_array($filteredData['estate_images'])) {
                $filteredData['estate_images'] = array_slice($filteredData['estate_images'], 0, 3);
            }

            return $filteredData;
        });
    }
}
