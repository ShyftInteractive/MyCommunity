<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Checklists;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChecklistIndex extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia(Action::getView($this));
    }
}
