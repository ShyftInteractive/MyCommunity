<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class NotificationIndex extends Controller
{
    public function __construct(public NotificationService $notificationService)
    {
    }

    public function __invoke(Request $request)
    {

        $banners = $this->notificationService->findBannerNotifications(
            workspaceID: $request->get('workspace_id'),
            terms: $request->get('banners'),
            count: $request->get('count'),
        );

        // $system = $this->notificationService->findSystemNotifications(
        //     workspaceID: $request->get('workspace_id'),
        //     terms: $request->get('system'),
        //     count: $request->get('count'),
        // );

        return inertia(Action::getView($this), compact('banners'));
    }
}
