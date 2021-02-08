<?php

namespace App\View\Components\Front;

use App\Domain\Models\MCS\Workspace\Notification;
use Illuminate\View\Component;

class Banner extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?Notification $banner)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->banner) {
            return view('components.front.banner');
        }
    }
}
