<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;
use App\Services\MCS\NotificationService;

class NotificationDelete extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function __invoke(string $notificationID, Request $request)
    {
        $this->notificationService->deleteByID(
            id: $notificationID
        );

        return redirect()->back()->with(['success' => 'Notification Deleted']);
    }
}
