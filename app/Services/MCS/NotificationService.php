<?php

declare(strict_types=1);

namespace App\Services\MCS;

use PDO;
use App\Services\BaseService;
use App\Enums\MCS\NotificationTypes;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Queries\NotificationQueries;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Models\MCS\Workspace\Notification;
use Illuminate\Support\Collection as SupportCollection;

class NotificationService extends BaseService
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function query()
    {
        return new NotificationQueries($this->model);
    }

    public function findBannerNotifications(string $workspaceID, ?string $terms, ?int $count = 10): Collection|LengthAwarePaginator
    {
        return $this->query()->notificationSearch(
            workspaceID: $workspaceID,
            type: NotificationTypes::BANNER()->getValue(),
            terms: $terms,
            fields: ['message', 'details'],
            count: (int) $count ?? 10
        );
    }

    public function findSystemNotifications(string $workspaceID, string $terms, int $count)
    {
        return $this->query()->notificationSearch(
            workspaceID: $workspaceID,
            type: NotificationTypes::MESSAGE()->getValue(),
            terms: $terms,
            fields: ['message', 'details'],
            count: (int) $count ?? 10
        );
    }

    public function createNewNotification(string $workspaceID, array|SupportCollection $request)
    {
        return $this->factory()->create([
            'workspace_id' => $workspaceID,
            'message' => $request['message'],
            'type' => $request['type'],
            'details' => $request['details'],
            'active' => $request['active'],
            'visibility' => $request['visibility'],
            'banner_dispaly_at' => $request['banner_display_at'],
            'banner_hide_at' => $request['banner_hide_at']
        ]);
    }

    public function updateNotification(string $notificationID, array $request)
    {
        return $this->factory()->updateWhere(
            col: 'id',
            value: $notificationID,
            updates: collect($request)->only(
                "id",
                "type",
                "message",
                "details",
                "visibility",
                "active",
                "banner_display_at",
                "banner_hide_at",
            )->toArray(),
        );
    }

    public function deleteByID(string $id)
    {
        return $this->factory()->removeAllIDs([$id]);
    }

    public function getAllSystemMessageNotifications(string $workspaceID): Collection|LengthAwarePaginator
    {
        return collect([]);
    }
}
