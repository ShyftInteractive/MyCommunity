<?php declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Events\Event;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseService;
use App\Domain\Events\EventRepository;

class EventService extends BaseService
{
    public function __construct(Event $model)
    {
        parent::__construct(
            repository: new EventRepository($model),
        );
    }

    public function createEvent(array $request, string $workspaceID, string $memberID)
    {
        return $this->repositiory->create($this->repository->resource(
            item: $request,
            workspaceID: $workspaceID,
            memberID: $memberID,
        ));
    }

    public function updateSelectedEvents(string $action, array $requests)
    {
        return match ($action) {
            'delete' => $this->removeItems(ids: $requests['selected'])
        };
    }

    public function updateEvent(string $workspaceID, string $memberID, string $eventID, array $request)
    {
        $this->updateItem(
            id: $eventID,
            updates: $this->repository->resource(
                item: $request,
                workspaceID: $workspaceID,
                memberID: $memberID,
            ),
        );
    }

    public function showEvent(string $workspaceID, string $eventID)
    {
        return $this->getWorkspaceItem(
            workspaceID: $workspaceID,
            id: $eventID
        );
    }

    public function findEvents(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
            ->searchWorkspace(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['title', 'description'],
                orderBy: 'start_at',
                count: $count
            );
    }


    public function getLastFiveEvents(string $workspaceID)
    {
        return $this->repository->getWorkspaceLatestEvents(
            workspaceID: $workspaceID,
            count: 5
        );
    }
}
