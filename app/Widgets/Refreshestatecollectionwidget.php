<?php

namespace App\Widgets;

use Statamic\Widgets\Widget;

class Refreshestatecollectionwidget extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('widgets.refreshestatecollectionwidget');
    }
}
