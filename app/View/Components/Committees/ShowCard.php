<?php

namespace App\View\Components\Committees;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowCard extends Component
{
    public $title;
    public $description;
    public $unique;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $description, $unique)
    {
        $this->title = $title;
        $this->description = $description;
        $this->unique = $unique;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.committees.show-card');
    }
}
