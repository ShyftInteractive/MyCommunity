<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use Illuminate\Http\Request;
use App\Domain\Events\EventService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventSelected extends Controller
{

    public function __construct(private EventService $eventService)
    {
    }


    public function __invoke(string $action, Request $request)
    {

        $this->eventService->updateSelectedEvents(
            action: $action,
            requests: $request->input(),
        );

        return redirect()->back()->with(['success' => 'Updated!']);
    }
}
