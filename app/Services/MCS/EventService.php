<?php

declare(strict_types=1);

namespace App\Services\MCS;

use App\Services\BaseService;
use App\Services\Queries\EventQueries;
use App\Domain\Models\MCS\Workspace\Event;

class EventService extends BaseService
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function query()
    {
        return new EventQueries($this->model);
    }

    public function getLastFiveEvents(string $workspaceID)
    {
        return $this->query()->getNextEvents(
            workspaceID: $workspaceID,
            count: 5
        );
    }
}
