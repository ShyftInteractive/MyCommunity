<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $events = Event::byWorkspace($request->get('workspace_id'))
            ->orderable(
                column: 'start_at',
            )->searchable(
                searchTerm: $request->get('s'),
                searchFields: ['title']
            )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'events' => $events->toArray(),
        ]);
    }
}
