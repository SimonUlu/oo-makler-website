<?php

namespace App\Helpers\Estates;

use App\Http\Controllers\SessionController;
use App\Modifiers\EuropeanNumber;
use App\Services\OnOfficeService;
use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;

class EstateHelper
{
    const FIELDSNOTINCLUDEDINFIELDLIST = ['referenz', 'veroeffentlichen'];

    public static function createProjectFilter()
    {
        $project_filter = [
            'stammobjekt' => [
                [
                    'op' => '=',
                    'val' => '1',
                ],
            ],
        ];

        return $project_filter;
    }

    public static function createSubEstateFilter($estateIds)
    {
        return [
            'Id' => [
                [
                    'op' => 'in',
                    'val' => $estateIds,
                ],
            ],
        ];
    }

    public static function getFilterFromRequest(Request $request)
    {
        // $filterInfo = SessionController::getFilterOptionFields();

        $request_filterinfo = $request->input('filter');

        // // each key from filterInfo is a filter. Thus get each key from request
        // foreach ($filterInfo as $key => $value) {
        //     // if key is not in request or value is not in filterInfo, continue
        //     if (! $request->has($key)) {
        //         continue;
        //     }
        //     // $filters[$key] = $value;;

        //     // if value is in filterInfo, add it to filters
        //     $filters[$key] = $request->query($key);
        // }
        if ($request_filterinfo) {
            foreach ($request_filterinfo as $key => $value) {
                if ($key == 'referenz') {
                    $filters[$key] = null;
                } else {
                    $filters[$key] = $value;
                }

            }
        }

        return $filters ?? [];
    }

    public static function prepareFilterFromCp(Request $request, OnOfficeService $onOfficeService, array $filters)
    {
        // get all estateFields from Session
        if ($request->session()->has('estateFieldsFull')) {
            $estateFields = $request->session()->get('estateFieldsFull');
        } else {
            SessionController::getAllEstateFields($request, $onOfficeService);
            $estateFields = $request->session()->get('estateFieldsFull');
        }
        // do processing for each filter
        foreach ($filters as $key => $filter) {
            // validate if key is in estateFields
            if (! in_array($filter['onoffice_label_id'], self::FIELDSNOTINCLUDEDINFIELDLIST) && ! array_key_exists($filter['onoffice_label_id'], $estateFields)) {
                continue;
            }
            // if filter has key onoffice_label_id
            if (array_key_exists('onoffice_label_id', $filter)) {
                $filters[$filter['onoffice_label_id']] = [
                    0 => [
                        'op' => $filter['operator'],
                        'val' => $filter['value'],
                    ],
                ];
                unset($filters[$key]);
            }
        }

        return $filters;
    }

    public static function getEstateFields(Request $request, OnOfficeService $onOfficeService)
    {
        // get all estateFields from Session
        if ($request->session()->has('estateFieldsFull') && ! empty($request->session()->get('estateFieldsFull'))) {
            $estateFields = $request->session()->get('estateFieldsFull');
        } else {
            SessionController::getAllEstateFields($request, $onOfficeService);
            $estateFields = $request->session()->get('estateFieldsFull');
        }

        return $estateFields;
    }

    public static function prepareFilterForOnOfficeApi(Request $request, OnOfficeService $onOfficeService, array $filters)
    {
        // filter from cp
        if (isset($filters[0]['onoffice_label_id']) && isset($filters[0]['operator']) && isset($filters[0]['value'])) {
            return self::prepareFilterFromCp($request, $onOfficeService, $filters);
        }

        $filterValidated = [];
        // get all estateFields from Session
        if ($request->session()->has('estateFieldsFull')) {
            $estateFields = $request->session()->get('estateFieldsFull');
        } else {
            SessionController::getAllEstateFields($request, $onOfficeService);
            $estateFields = $request->session()->get('estateFieldsFull');
        }

        // dd($filters);
        // prepare filter for onOffice API
        foreach ($filters as $key => $value) {
            // if value is empty, continue
            if (empty($value)) {
                continue;
            }

            // if value has __ in it (e.g. __from or __to), explode and get first value and second value in variables
            if (is_string($key) && strpos($key, '__') !== false) {
                $keyExploded = explode('__', $key);
                $key = $keyExploded[0];
                $operator = $keyExploded[1];
                if ($operator == 'von') {
                    $operator = '>=';
                }
                if ($operator == 'bis') {
                    $operator = '<=';
                }
                // case if both are set
                if (isset($filters[$key.'__von']) && isset($filters[$key.'__bis'])) {
                    $filterValidated[strtolower($key)] = [
                        0 => [
                            'op' => 'BETWEEN',
                            'val' => [$filters[$key.'__von'], $filters[$key.'__bis']],
                        ],
                    ];

                    // [$filterKey, $filterValue] = self::addFilterSpecialCase($key);

                    if (isset($filterKey) && isset($filterValue)) {
                        $filterValidated[strtolower($filterKey)] = $filterValue;
                    }

                    continue;
                }
            }

            // validate if key is in estateFields
            if (! array_key_exists($key, $estateFields)) {
                continue;
            }

            // if value is an array, make an IN filter
            if (! is_array($value)) {
                $filterValidated[strtolower($key)] = [
                    0 => [
                        'op' => isset($operator) ? $operator : '=',
                        'val' => is_numeric($value) ? (int) $value : $value,
                    ],
                ];
            }
            $replacements = [
                'Büro/Praxen' => 'buero_praxen',
                'Hallen/Lager/Produktion' => 'hallen_lager_prod',
                'Zins und Renditeobjekt' => 'zinshaus_renditeobjekt',
                'Grundstück' => 'grundstueck',
            ];
            if (is_array($value)) {
                // skip for "Alle Orte"
                if ($key == 'ort' && in_array('Alle Orte', array_values($value))) {
                    unset($filterValidated[$key]);

                    continue;
                }
                foreach ($replacements as $match => $replacement) {
                    if (in_array($match, $value)) {
                        array_push($value, $replacement);
                    }
                }
                // build for other locations
                $filterValidated[strtolower($key)] = [
                    0 => [
                        'op' => 'IN',
                        'val' => array_values($value),
                    ],
                ];
            }

            [$filterKey, $filterValue] = self::addFilterSpecialCase($filters, $key);

            if (isset($filterKey) && isset($filterValue)) {
                $filterValidated[strtolower($filterKey)] = $filterValue;
            }
        }

        // dd($filterValidated);
        return $filterValidated;
    }

    public static function getFilterEstateReferences()
    {
        return GlobalSet::find('estate_filter_configuration')->in('default')->get('references_filter_options') ?? [];
    }

    public static function getLocations(string $locationSpecifier, array $estates)
    {
        // check if $estates is a collection. if not make it one
        if (! is_a($estates, 'Illuminate\Support\Collection')) {
            $estates = collect($estates);
        }

        // get all locations from the estates
        $estateLocations = array_values(array_filter($estates->pluck('elements.'.$locationSpecifier)->unique()->toArray()));

        return $estateLocations;
    }

    public static function addFilterSpecialCase($filters, $key)
    {
        // add special cases for certain fields
        // 1. if kaufpreis is queried, set vermarktungsart = kauf if there is not explicitly set vermarktungsart
        if ($key == 'kaufpreis' && ! isset($filters['vermarktungsart'])) {
            return [
                'vermarktungsart', [
                    0 => [
                        'op' => '=',
                        'val' => 'kauf',
                    ],
                ],
            ];
        }
    }

    public static function getAllEstatesWithImages($request, $onOfficeService, $filters = [], $offset = 0, $limit = 500, $language = 'DEU', $sessionNameEstates = 'all_estates', $sessionNameImages = 'allEstateImages')
    {
        // if call comes from home
        if (! $request->session()->has($sessionNameEstates) || empty($request->session()->get($sessionNameEstates))) {
            // call SessionController to get estates
            SessionController::updateEstates($request, $onOfficeService, $filters, $sessionNameEstates, $limit);
            $estates = $request->session()->get($sessionNameEstates);
        } else {
            $estates = $request->session()->get($sessionNameEstates);
        }

        return $estates ?? [];
    }

    public static function getEstatesWithImages($request, $onOfficeService, $filters = [], $offset = 0, $limit = 500, $language = 'DEU', $sessionNameEstates = 'estates', $sessionNameImages = 'estateImages')
    {
        $request_vermarktungsart = $request->input('serverMemo.data.filter.vermarktungsart');
        // get estates from session
        // if the filter changed we need to query the onOffice API again and thus, forget the estate session variable
        if ($filters != $request->session()->get('filter')) {
            $request->session()->forget($sessionNameEstates);
        } elseif ($request_vermarktungsart) {
            if (! isset($filters['vermarktungsart'])) {
                $request->session()->forget($sessionNameEstates);
            }

        }

        if (! $request->session()->has($sessionNameEstates)
            || empty($request->session()->get($sessionNameEstates)
            )) {
            // call SessionController to get estates
            SessionController::updateEstates($request, $onOfficeService, $filters, $sessionNameEstates, $limit);
            $estates = $request->session()->get($sessionNameEstates);
            // dd("Hallo");
        } else {
            $estates = $request->session()->get($sessionNameEstates);
        }

        // dd($request->session()->get($sessionNameEstates));
        // dd($estates);
        return $estates ?? [];
    }

    public static function getFilterInfo($filters, $filterOptions, $filterKey = null, $recursive = false)
    {
        $filter_info = [];

        if (request()->session()->has('estateFieldsFull')) {
            $estateFields = request()->session()->get('estateFieldsFull');
        } else {
            SessionController::getAllEstateFields(request(), new OnOfficeService());
            $estateFields = request()->session()->get('estateFieldsFull');
        }

        foreach ($filters as $key => $value) {

            // skip for empty values
            if (empty($value)) {
                continue;
            }

            // check if key is in estatefields
            $keyCheck = $key;
            if (is_string($key) && strpos($key, '__') !== false) {
                $keyCheck = explode('__', $key)[0];
            }
            if (! array_key_exists($keyCheck, $estateFields)) {
                continue;
            }

            // check if is multiselect or singleselect or city (ort)
            if (in_array($estateFields[$keyCheck]['type'], ['multiselect', 'singleselect']) || $keyCheck == 'ort') {
                continue;
            }

            // skip when __von or __bis is also set
            if (isset($filters[$key.'__von']) || isset($filters[$key.'__bis'])) {
                unset($filters[$key]);

                continue;
            }

            $key_raw = $key;
            // explode value if required
            if (is_string($key) && strpos($key, '__') !== false) {
                $exploded = explode('__', $key);
                $key = $exploded[0];
                $filterAddition = $exploded[1];
            }

            // if is recursive, set key to filterKey
            if ($recursive) {
                $label_id = $filterKey;
            } else {
                $label_id = $key;
            }
            // if value is array, go into this function again
            if (is_array($value)) {
                $filter_info = array_merge($filter_info, self::getFilterInfo($value, $filterOptions, $label_id, true));

                continue;
            }
            // check if key is a valid filterOption
            if (! array_key_exists($value, $filterOptions) && ! array_key_exists($label_id, $filterOptions)) {
                continue;
            }

            // check if value needs formatting
            $permittedValuesExist = isset($filterOptions[$key]['permittedvalues']) ? true : false;
            $formattedValue = $permittedValuesExist ? $filterOptions[$key]['permittedvalues'][$label_id] : $label_id;
            // check if filter requires further validaton (type is select, multiselect)
            if (in_array($filterOptions[$label_id]['type'], ['select', 'multiselect'])) {
                dd('do further validation');
            }

            $value_raw = $value;

            // if filter is varchar get filter info with no further validation
            if ($filterOptions[$label_id]['type'] == 'varchar') {
                $value = isset($filterAddition) ? $filterAddition.''.$value : $value;
            }

            // if datatype is monetary, format with european number and euro sign
            if ($filterOptions[$label_id]['fieldMeasureFormat'] == 'DATA_TYPE_MONETARY') {
                $value = EuropeanNumber::index(value: $value, decimals: 0).' €';
            }

            // dd($value, $value_raw, $filterOptions[$label_id]['fieldMeasureFormat']);

            // if value is empty, continue
            if (empty($value)) {
                continue;
            }

            $filter_info[] = [
                'label_id' => $label_id,
                'key' => $key,
                'key_raw' => isset($key_raw) ? $key_raw : $key,
                'value' => isset($filterAddition) ? $filterAddition.' '.$value : $value,
                'value_raw' => $value_raw,
            ];
        }

        // Result
        return $filter_info;
    }
}
