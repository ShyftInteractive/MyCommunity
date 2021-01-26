<?php

declare(strict_types=1);

namespace App\Services\Queries;

use App\Services\BaseQueries;
use Illuminate\Support\Carbon;
use App\Domain\Models\MCS\Workspace\Event;
use Illuminate\Database\Eloquent\Collection;
use App\Domain\Models\MCS\Workspace\Notification;

class NotificationQueries extends BaseQueries
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function notificationSearch(string $workspaceID, ?string $type, ?string $terms, array $fields, int $count = 10)
    {
        return $this->model
            ->byWorkspace($workspaceID)
            ->where('type', $type)
            ->searchable($terms, $fields)
            ->orderBy('created_at')
            ->paginate($count);
    }
}
