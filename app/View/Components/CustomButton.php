<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Statamic\Globals\GlobalSet;

class CustomButton extends Component
{
    /**
     * Create a new component instance.
     */
    public $hrefTag;

    public $rounded;

    public $text;

    public $color;

    public $hasArrow;

    public $bold;

    public $textSize;

    public function __construct($hrefTag, $text, $color, $hasArrow, $bold, $textSize = 'text-md')
    {
        $this->hrefTag = $hrefTag;
        $this->rounded = GlobalSet::find('browser_appearance')->in('default')->get('rounded_buttons');
        $this->text = $text;
        $this->color = $color;
        $this->hasArrow = $hasArrow;
        $this->bold = $bold;
        $this->textSize = $textSize;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.subcomponents.buttons.custom-button');
    }
}
