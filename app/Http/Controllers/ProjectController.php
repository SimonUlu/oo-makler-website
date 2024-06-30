<?php

namespace App\Http\Controllers;

use Statamic\View\View;
use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;
use App\Services\OnOfficeService;
use App\Helpers\Estates\EstateHelper;
use App\Services\EstateHandlers\EstateEntryService;
use Statamic\Facades\Collection;

class ProjectController extends Controller
{
    public function index(Request $request, OnOfficeService $onOfficeService)
    {
        // get information from statamic cp

        $header_image = GlobalSet::find('onoffice_projects')->in('default')->get('header_image')[0];
        $estate_pages = GlobalSet::find('onoffice_projects')->in('default')->get('estate_pages');
        $cta_headline = GlobalSet::find('onoffice_projects')->in('default')->get('cta_headline');
        $cta_sub_header = GlobalSet::find('onoffice_projects')->in('default')->get('cta_sub_header');
        $image_second = GlobalSet::find('onoffice_projects')->in('default')->get('image_second');
        $imageSectionHeader = GlobalSet::find('onoffice_projects')->in('default')->get('imagesectionheader');
        $imageSectionDescription = GlobalSet::find('onoffice_projects')->in('default')->get('imagesectiondescription');
        $imageSectionList = GlobalSet::find('onoffice_projects')->in('default')->get('imagesectionlist');

        $content_with_image_replicator = GlobalSet::find('onoffice_projects')->in('default')->get('content_with_image_replicator');


        // Services import

        $services_header = GlobalSet::find('onoffice_projects')->in('default')->get('services_header');
        $services_text = GlobalSet::find('onoffice_projects')->in('default')->get('services_subheader');
        $services_replicator = GlobalSet::find('onoffice_projects')->in('default')->get('services');




        $collectionName = 'estate_entries';
        // check if there is a filter active
        $homeViewModelFilters = GlobalSet::find('onoffice')->in('default')->get('home_view_model_filter');

        // Filter the collection to find the entry with the specific "home_view_model_filter_name"
        $filteredEntryProjects = EstateEntryService::getFilteredEntry($homeViewModelFilters, 'projects');


        // get filters
        $filtersProjects = OnOfficeService::transformFilterArray($filteredEntryProjects);
        $estates = EstateEntryService::getEstatesUnpaginated($filtersProjects, 3, 'erstellt_am', 'desc', $collectionName);



        $project_categories = GlobalSet::find('estate_filter_configuration')->in('default')->get('categories');

        $reference_projects = Collection::findByHandle('referenzprojekte')->queryEntries()->get()->toArray();


        $categorizedProjects = [];

        // Für jedes Element in $data...
        foreach ($estates as $item) {

            // Durchlaufen Sie $categoryData, um die Kategorie zu ermitteln.
            foreach ($project_categories as $category) {

                // Falls die 'onofficelabel' der Kategorie  mit 'status' des elements übereinstimmt, fügt das element zur Kategorie hinzu.
                if ($category['onofficelabel'] === $item->data()->all()['status2']) {
                    $categorizedProjects[$category['name']][] = $item->data()->all();
                }
            }
        }

        // dd($services_replicator);

        return (new View)
            ->template('neubauprojekte.onoffice.index')
            ->layout('layouts.layoutblade')
            ->with([
                'header_image' => $header_image,
                'estate_pages' => $estate_pages,
                'before_title' => $collectionData[0]['before_title'] ?? null,
                'onOfficeService' => $onOfficeService,
                'title' => 'Neubauprojekte',
                'after_title' => $collectionData[0]['after_title'] ?? null,
                'imagesectionlist' => $imageSectionList,
                'imagesectiondescription' => $imageSectionDescription,
                'imagesectionheader' => $imageSectionHeader,
                'image_second' => $image_second,
                'cta_sub_header' => $cta_sub_header,
                'cta_headline' => $cta_headline,
                'categorizedProjects' => $categorizedProjects,
                'content_with_image_replicator' => $content_with_image_replicator,
                'services_header' => $services_header,
                'services_text' => $services_text,
                'services_replicator' => $services_replicator,
                'reference_projects' => $reference_projects,
            ]);
    }

    public function show(OnOfficeService $onOfficeService, $estateId)
    {

        if (! is_numeric($estateId)) {
            // return page not found view
            return self::estateNotFound();
        }

        $estate = $onOfficeService->getEstateById($estateId);

        // get info from cp
        $neubautenGlobals = GlobalSet::find('neubauten')->in('default')->get('neubau');

        $filteredNeubauten = array_filter($neubautenGlobals, function ($item) use ($estateId) {
            return isset($item['neubau_id']) && $item['neubau_id'] == $estateId;
        });

        // Da array_filter die keys des Original-Arrays beibehält, können Sie array_values verwenden, um die Keys zurückzusetzen, falls notwendig.
        $filteredNeubauten = array_values($filteredNeubauten);

        if (isset($filteredNeubauten[0]['four_grid_text_with_icons'])) {
            $services = $filteredNeubauten[0]['four_grid_text_with_icons'];
        } else {
            $services = [];
        }

        // get info form onOffice
        $estateImages = $estate['elements']['images'];

        $panoramaImages = array_filter($estateImages, function ($image) {
            return $image['type'] == 'Panorama';
        });

        $fotoImages = array_filter($estateImages, function ($image) {
            return $image['type'] == 'Foto';
        });

        $fotoHugeImages = array_filter($estateImages, function ($image) {
            return $image['type'] == 'Foto_gross';
        });

        $titleImages = array_filter($estateImages, function ($image) {
            return $image['type'] == 'Titelbild';
        });

        $user = $onOfficeService->getOnOfficeUserById($estate['elements']['benutzer']);
        $photo = $onOfficeService->getUserPhotoById($estate['elements']['benutzer']);

        $subEstatesData = $this->loadSubEstates($onOfficeService, [$estateId]);

        // return view
        return (new View)
            ->template('neubauprojekte.onoffice.show')
            ->layout('layouts.layoutblade')
            ->with([
                'title' => substr($estate['elements']['objekttitel'], 0, 10).'...',
                'estate' => $estate,
                'estateId' => $estate['id'],
                'panoramaImages' => $panoramaImages,
                'fotoImages' => $fotoImages,
                'fotosHuge' => $fotoHugeImages,
                'titleImages' => $titleImages,
                'onOfficeUser' => $user,
                'userPhoto' => $photo['elements']['photo'],
                'subEstatesData' => $subEstatesData,
                'services' => $services,
            ]);
    }

    private function loadSubEstates(OnOfficeService $onOfficeService, $estateId)
    {
        $response = $onOfficeService->getSubEstates($estateId);

        // dd($response);
        $elements = $response['data']['records'][0]['elements'];

        $subEstateIds = $this->getAllIds($elements);

        $filter = EstateHelper::createSubEstateFilter($subEstateIds);

        return $onOfficeService->getEstatesWithFloorImages($filter);
    }

    private function getAllIds($response)
    {
        $values = [];

        foreach ($response as $item) {
            if (is_array($item)) {
                $values = array_merge($values, $this->getAllIds($item));
            } else {
                $values[] = $item;
            }
        }

        return $values;
    }

    public function estateNotFound()
    {
        return (new View)
            ->template('errors.404-estate')
            ->layout('layouts.layoutblade')
            ->with(
                [
                    'title' => '😳',
                    'title_sub' => 'Diese Immobile ist nicht mehr in der Vermarktung.',
                    'cta_text' => 'Damit das in Zukunft nicht nochmal passiert, jetzt direkt Suchauftrag erstellen.',
                    'cta_button_link' => '/suchauftrag',
                    'cta_button_text' => 'Suchauftrag erstellen',
                ]
            );
    }
}
