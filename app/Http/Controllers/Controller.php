<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected $viewLocation;

    public function __construct()
    {

    }

    public function getInertiaView(string $name, array $props = [])
    {
        $name = "{$this->viewLocation}/{$name}";

        return inertia($name, $props);
    }
}
