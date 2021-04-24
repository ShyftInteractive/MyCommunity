<?php declare(strict_types=1);

namespace App\Domain\Notifications;

use App\Domain\Base\BaseFactory;
use App\Domain\Base\BaseService;
use App\Enums\MCS\NotificationTypes;
use App\Domain\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Domain\Notifications\NotificationRepository;

class NotificationService extends BaseService
{
    public function __construct(Notification $model)
    {
        parent::__construct(
            repository: new NotificationRepository($model),
            factory: new BaseFactory($model),
        );
    }

    public function resource(array $item, string $workspaceID)
    {
        return [
            'workspace_id' => $workspaceID,
            'message' => $item['message'],
            'type' => $item['type'],
            'details' => $item['details'],
            'active' => $item['active'],
            'visibility' => $item['visibility'],
        ];
    }

    public function getLastFiveMessages(string $workspaceID)
    {
        return $this->repository->getWorkspaceLatestNotification(
            workspaceID: $workspaceID,
            type: NotificationTypes::MESSAGE()->getValue(),
            count: 5,
        );
    }

    public function findBannerNotifications(string $workspaceID, ?string $terms, ?int $count)
    {
        return $this->repository->searchableNotifications(
            workspaceID: $workspaceID,
            type: NotificationTypes::BANNER()->getValue(),
            terms: $terms,
            fields: ['message', 'details'],
            count: (int) $count ?? 10
        );
    }

    public function findSystemNotifications(string $workspaceID, string $terms, ?int $count)
    {
        return $this->repository->searchableNotifications(
            workspaceID: $workspaceID,
            type: NotificationTypes::MESSAGE()->getValue(),
            terms: $terms,
            fields: ['message', 'details'],
            count: (int) $count ?? 10
        );
    }

    public function createNewNotification(string $workspaceID, array $request)
    {
        return $this->factory->create($this->resource(
            item: $request,
            workspaceID: $workspaceID,
        ));
    }

    public function updateNotification(string $notificationID, string $workspaceID, array $request)
    {
        return $this->updateItem(
            id: $notificationID,
            updates: $this->resource(
                item: $request,
                workspaceID: $workspaceID,
            )
        );
    }

    public function getAllSystemMessageNotifications(string $workspaceID): Collection|LengthAwarePaginator
    {
        return collect([]);
    }

    public function getActiveBanner(string $workspaceID)
    {
        return $this->repository->getActiveBannerScopedToWorkspace(
            workspaceID: $workspaceID
        );
    }
}
