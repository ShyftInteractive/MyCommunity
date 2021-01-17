<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventDelete extends Controller
{
    public function __invoke(string $eventID, Request $request)
    {
        Event::destroy($eventID);

        return redirect()->back()->with(['success' => 'Event Deleted']);
    }
}
