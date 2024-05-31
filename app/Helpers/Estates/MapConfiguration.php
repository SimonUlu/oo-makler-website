<?php

namespace App\Helpers\Estates;

use Statamic\Facades\GlobalSet;

class MapConfiguration
{
    public $zoom;

    public $centerLat;

    public $centerLng;

    public $style;

    public function __construct()
    {
        $config = GlobalSet::find('estate_map_configuration')->in('default');
        $this->zoom = $config->get('zoom');
        $this->centerLat = $config->get('center_lat');
        $this->centerLng = $config->get('center_lng');
        $this->style = $config->get('style');
    }
}
