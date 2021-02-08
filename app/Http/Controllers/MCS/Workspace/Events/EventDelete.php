<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use Illuminate\Http\Request;
use App\Domain\Events\EventService;
use App\Http\Controllers\Controller;

class EventDelete extends Controller
{
    public function __construct(private EventService $eventService)
    {
    }

    public function __invoke(string $eventID, Request $request)
    {
        $this->eventService->removeItems(ids: [$eventID]);

        return redirect()->back()->with(['success' => 'Event Deleted']);
    }
}
