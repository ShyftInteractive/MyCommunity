<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class NotificationDelete extends Controller
{
    public function __construct(private NotificationService $notificationService) { }

    public function __invoke(string $notificationID, Request $request)
    {
        $this->notificationService->removeItems(ids: [$notificationID]);

        return redirect()->back()->with(['success' => 'Notification Deleted']);
    }
}
