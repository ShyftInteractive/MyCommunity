<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Workspace\Dashboard;

use Inertia\Response;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class Dashboard extends Controller
{
    public function __invoke(Request $request): Response
    {

        $events = Event::byWorkspace($request->get('workspace_id'))->get();

        return inertia(Action::getView($this), [
            'events' => $events->toArray()
        ]);
    }
}
