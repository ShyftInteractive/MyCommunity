<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class NotificationSelected extends Controller
{
    public function __invoke(string $action, Request $request)
    {
    }
}
