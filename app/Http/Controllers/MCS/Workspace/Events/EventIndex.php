<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Events\EventService;
use App\Http\Controllers\Controller;

class EventIndex extends Controller
{
    public function __construct(private EventService $eventService)
    {
    }

    public function __invoke(Request $request)
    {
        $events = $this->eventService->findEvents(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );


        return inertia(Action::getView($this), [
            'events' => $events->toArray(),
        ]);
    }
}
