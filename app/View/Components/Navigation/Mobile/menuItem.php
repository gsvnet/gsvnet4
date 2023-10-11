<?php

namespace App\View\Components\Navigation\Mobile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class menuItem extends Component
{
    public $link;
    public $title;

    /**
     * Create a new component instance.
     */
    public function __construct($link, $title)
    {
        $this->link = $link;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.mobile.menu-item');
    }
}
