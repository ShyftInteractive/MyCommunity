<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Workspace\Dashboard;

use Inertia\Response;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Services\MCS\EventService;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function __construct(
        private EventService $eventService,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $events = $this->eventService->getLastFiveEvents($request->get('workspace_id'));

        // $latestNotices = $this->notificationService->getLastFiveNoitces();
        // $bannerNotice = $this->notificationService->getActiveBanner();

        return inertia(Action::getView($this), compact('events'));
    }
}
