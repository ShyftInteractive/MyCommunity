<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Workspace\Dashboard;

use Inertia\Response;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Events\EventService;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class Dashboard extends Controller
{
    public function __construct(private EventService $eventService, private NotificationService $notificationService) { }

    public function __invoke(Request $request): Response
    {
        $events = $this->eventService->getLastFiveEvents($request->get('workspace_id'));
        $messages = $this->notificationService->getLastFiveMessages($request->get('workspace_id'));

        return inertia(Action::getView($this), compact('events', 'messages'));
    }
}
