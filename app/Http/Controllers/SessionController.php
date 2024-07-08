<?php

namespace App\Http\Controllers;

use App\Helpers\Estates\EstateHelper;
use App\Services\OnOfficeService;
use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;

class SessionController extends Controller
{
    // Get All estate locations
    public static function getAllLocations(Request $request)
    {
        $all_estates = $request->session()->get('all_estates');
        // dd($alle_estates);
        if ($all_estates != null) {
            $all_locations = EstateHelper::getLocations('ort', $all_estates) ?? null;
        } else {
            $all_locations = EstateHelper::getLocations('ort', []) ?? null;
        }

        return $all_locations;
    }

    public static function getLocationsOfAllEstates(Request $request, OnOfficeService $onOfficeService, $filters)
    {
        // get estates from session
        $all_estates = $request->session()->get('estatesForLocations');
        $filters = EstateHelper::prepareFilterForOnOfficeApi($request, $onOfficeService, $filters);
        $filters = self::prepareLocationFilter($filters);
        $saved_filters = $request->session()->get('filters');
        // on initial call
        if ($all_estates == null) {
            $request->session()->forget('estatesForLocations');
            $all_estates = self::updateEstateLocations($request, $onOfficeService, $filters);
            $all_locations = EstateHelper::getLocations('ort', $all_estates) ?? null;
        } else {
            if ($saved_filters == $filters) {
                $all_locations = $request->session()->get('filters');
            } else {
                self::updateEstateLocations($request, $onOfficeService, $filters);
                $all_estates = $request->session()->get('estatesForLocations');
                $all_locations = EstateHelper::getLocations('ort', $all_estates);
            }

        }

        return $all_locations;
    }

    public static function prepareLocationFilter($filter)
    {
        if (array_key_exists('ort', $filter)) {
            unset($filter['ort']);
        }

        return $filter;
    }

    public static function updateEstateLocations(Request $request, OnOfficeService $onOfficeService, array $filters)
    {
        $estatesForLocations = $onOfficeService->getEstatesWithImages($filters, 0, 15);
        // dd($estatesForLocations);
        $request->session()->put('estatesForLocations', $estatesForLocations);

        return $estatesForLocations;
    }

    public static function updateEstates(Request $request, OnOfficeService $onOfficeService, array $filters, $sessionName = 'estates', $limit = 15)
    {
        if ($sessionName == 'estates') {
            $filters = array_merge($filters, [
                'referenz' => [
                    ['op' => '=', 'val' => 0],
                ],
            ]);
        }
        if ($sessionName == 'estateReferences') {
            $filters = array_merge($filters, [
                'referenz' => [
                    ['op' => '=', 'val' => 1],
                ],
            ]);
        }
        // get estates from onOffice API
        $estates = $onOfficeService->getEstatesWithImages($filters, 0, $limit);

        // put estates in session
        $request->session()->put($sessionName, $estates);

        // Wenn von wo anders aufgerufen wurde vergesse alle filter und putte sie dann wieder.
        $request->session()->forget('filters');
        $request->session()->put('filters', $filters);
    }

    public static function updateEstateImages(Request $request, OnOfficeService $onOfficeService, array $filters, $estateCategories = null, $language = 'DEU', $sessionNameEstates = 'estates', $sessionNameImages = 'estateImages')
    {
        // get estates from session if estates exists. if not call updateEstates
        if (! $request->session()->has($sessionNameEstates) || empty($request->session()->get($sessionNameEstates))) {
            // call SessionController to get estates
            self::updateEstates($request, $onOfficeService, $filters);
        }

        // get estates from session
        $estates = $request->session()->get($sessionNameEstates);

        // get all ids that will be used to get estate images
        $estateIds = array_column($estates, 'id');

        // get estate images from onOffice API
        $estateImages = $onOfficeService->getEstateImagesByIds($estateIds, $estateCategories, $language);

        // put estate images in session
        $request->session()->put($sessionNameImages, $estateImages);
    }

    public static function getFieldListFromCp()
    {
        $locale = app()->getLocale();
        $globalSet = GlobalSet::findByHandle('estate_filter_configuration');
        $list = [];

        if ($globalSet) {
            $localizations = $globalSet
                ->localizations()
                ->pluck('locale')
                ->all();

            if (empty(array_filter($localizations))) {
                $locale = 'default';
            }

            if (in_array($locale, $localizations) || $locale === 'default') {
                $list = $globalSet
                    ->in($locale)
                    ->data()
                    ->get('estate_field_list');
            }
        }

        if (! empty($list)) {
            $list = collect($list)
                ->map(function ($filterOption) {
                    return $filterOption['onoffice_label_id'];
                })
                ->all();
        }

        return $list;
    }

    public static function getFilterOptionFields()
    {
        $locale = app()->getLocale();
        $globalSet = GlobalSet::findByHandle('estate_filter_configuration');
        $filterOptions = [];

        if ($globalSet) {
            $localizations = $globalSet
                ->localizations()
                ->pluck('locale')
                ->all();

            if (empty(array_filter($localizations))) {
                $locale = 'default';
            }

            if (in_array($locale, $localizations) || $locale === 'default') {
                $filterOptions = $globalSet
                    ->in($locale)
                    ->data()
                    ->get('filter_options');
            }
        }

        if (! empty($filterOptions)) {
            $filterOptions = collect($filterOptions)
                ->filter(function ($filterOption) {
                    return $filterOption['enabled'];
                })
                ->map(function ($filterOption) {
                    return $filterOption['onoffice_label_id'];
                })
                ->all();
        }

        return $filterOptions;
    }

    public static function fillFilterOptions(array $filterOptions)
    {

        $estateFields = EstateHelper::getEstateFields();

        foreach ($filterOptions as $key => $filterOption) {

            if (! array_key_exists($filterOption, $estateFields)) {
                unset($filterOptions[$key]);

                continue;
            }
            // if val is boolean or string boolean, make it 1 or 0
            if (is_bool($estateFields[$filterOption]) || $estateFields[$filterOption] === 'true' || $estateFields[$filterOption] === 'false') {
                $estateFields[$filterOption] = $estateFields[$filterOption] ? 1 : 0;
            }
            // set filter option
            $filterOptions[$filterOption] = $estateFields[$filterOption];
            $filterOptions[$filterOption]['label_filter'] = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('onoffice_label_id', $filterOption)->first()['label_filter'] ?? $filterOptions[$filterOption]['label'];
            // set label from cp backend
            $filterOptions[$filterOption]['filter_enabled_rent_case'] = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('onoffice_label_id', $filterOption)->first()['filter_enabled_rent_case'] ?? true;
            $filterOptions[$filterOption]['filter_enabled_buy_case'] = collect(GlobalSet::find('estate_filter_configuration')->in('default')->get('filter_options'))->where('onoffice_label_id', $filterOption)->first()['filter_enabled_buy_case'] ?? true;
            // unset filter option key
            unset($filterOptions[$key]);
        }

        // dd($filterOptions);
        return $filterOptions;
    }

    public static function getAllEstateFields()
    {
        // get all estate fields from onOffice API
        $estateFields = (new OnOfficeService())->getAllEstateFields();
        // put estate fields in session
        request()->session()->put('estateFieldsFull', $estateFields);
    }
}
