<?php

namespace App\View\Components\Committees;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowPreviousMember extends Component
{
    public $member;

    /**
     * Create a new component instance.
     */
    public function __construct($member)
    {
        $this->member = $member;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.committees.show-previous-member');
    }
}
