<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Admin;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Hell extends Controller
{
    public function __invoke(string $customerID, Request $request)
    {
        return inertia(Action::getView($this));
    }
}
