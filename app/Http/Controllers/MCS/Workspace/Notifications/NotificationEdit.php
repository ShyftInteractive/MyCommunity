<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class NotificationEdit extends Controller
{
    public function __construct(private NotificationService $notificationService) { }

    public function __invoke(string $notificationID, Request $request)
    {
        $notification = $this->notificationService->getWorkspaceItem(
            workspaceID: $request->get('workspace_id'),
            id: $notificationID,
        );

        return inertia(Action::getView($this),[
            'notification' => $notification
        ]);
    }
}
