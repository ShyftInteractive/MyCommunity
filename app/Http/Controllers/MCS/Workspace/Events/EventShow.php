<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Events\EventService;
use App\Http\Controllers\Controller;

class EventShow extends Controller
{
    public function __construct(private EventService $eventService) { }

    public function __invoke(string $eventID, Request $request)
    {
        $event = $this->eventService->showEvent(
            workspaceID: $request->get('workspace_id'),
            eventID: $eventID,
        );

        return inertia(Action::getView($this), [
            'event' => $event
        ]);
    }
}
