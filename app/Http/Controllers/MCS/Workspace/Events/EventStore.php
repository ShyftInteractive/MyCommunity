<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Domain\Events\EventService;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;

class EventStore extends Controller
{
    public function __construct(private EventService $eventService) { }

    public function __invoke(EventRequest $request)
    {
        $this->eventService->createEvent(
            request: $request->input(),
            workspaceID: $request->get("workspace_id"),
            memberID: auth()->user()->id,
        );

        return redirect()->route('event.index');
    }
}
