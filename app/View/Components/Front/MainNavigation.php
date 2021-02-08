<?php

namespace App\View\Components\Front;

use Illuminate\View\Component;
use App\Domain\Models\MCS\Workspace\Page;
use App\Domain\Collections\MCS\PageCollection;

class MainNavigation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?PageCollection $pages)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.front.main-navigation');
    }
}
