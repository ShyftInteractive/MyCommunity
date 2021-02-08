<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class NotificationUpdate extends Controller
{
    public function __construct(private NotificationService $notificationService) { }

    public function __invoke(string $notificationID, Request $request)
    {
        $this->notificationService->updateNotification(
            notificationID: $notificationID,
            request: $request->input(),
            workspaceID: $request->get('workspace_id'),
        );

        return redirect()->back()->withSuccess('Saved');
    }
}
