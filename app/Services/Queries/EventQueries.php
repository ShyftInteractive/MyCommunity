<?php

declare(strict_types=1);

namespace App\Services\Queries;

use App\Services\BaseQueries;
use Illuminate\Support\Carbon;
use App\Domain\Models\MCS\Workspace\Event;
use Illuminate\Database\Eloquent\Collection;

class EventQueries extends BaseQueries
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function getNextEvents(string $workspaceID, int $count = 10): Collection
    {
        return $this->model
            ->where('workspace_id', $workspaceID)
            ->where('start_at', '>=', Carbon::now())
            ->limit($count)
            ->get();
    }
}
