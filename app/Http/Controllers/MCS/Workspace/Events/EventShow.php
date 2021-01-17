<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventShow extends Controller
{
    public function __invoke(string $eventID, Request $request)
    {
        return inertia(Action::getView($this), [
            'event' => Event::byID($eventID)->first(),
        ]);
    }
}
