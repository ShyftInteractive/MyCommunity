<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class NotificationStore extends Controller
{
    public function __construct(private NotificationService $notificationService) { }

    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $this->notificationService->createNewNotification(
            workspaceID: $request->get('workspace_id'),
            request: $request->input(),
        );

        return redirect()->route('notification.index')->with('success', 'Notification Created');
    }

    private function rules(string $workspaceID): array
    {
        return [
            'message' => 'required',
            'type' => 'required',
        ];
    }
}
