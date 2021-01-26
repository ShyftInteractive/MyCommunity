<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class NotificationEdit extends Controller
{
    public function __invoke(string $notificationID, Request $request)
    {
    }
}
