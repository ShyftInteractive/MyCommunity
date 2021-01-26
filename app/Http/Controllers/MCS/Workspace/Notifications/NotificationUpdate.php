<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;
use App\Services\MCS\NotificationService;

class NotificationUpdate extends Controller
{

    public function __construct(private NotificationService $notificationService)
    {
    }

    public function __invoke(string $notificationID, Request $request)
    {
        $this->notificationService->updateNotification(
            notificationID: $notificationID,
            request: $request->input()
        );

        return redirect()->back()->withSuccess('Saved');
    }
}
