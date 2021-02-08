<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Domain\Events\EventService;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;

class EventUpdate extends Controller
{
    public function __construct(private EventService $eventService) { }

    public function __invoke(string $eventID, EventRequest $request)
    {

        $this->eventService->updateEvent(
            workspaceID: $request->get('workspace_id'),
            eventID:$eventID,
            memberID: auth()->user()->id,
            request: $request->input()
        );

        return redirect()->back()->withSuccess('Your event has been updated');
    }
}
