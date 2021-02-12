<?php declare(strict_types=1);

namespace App\Domain\Notifications;

use App\Domain\Base\BaseRepository;
use App\Domain\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository extends BaseRepository
{

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function getWorkspaceLatestNotification(string $workspaceID, string $type, int $count): Collection
    {
        return $this->model
            ->byWorkspace($workspaceID)
            ->where('type', $type)
            ->orderBy('created_at')
            ->limit($count)
            ->get();
    }

    public function searchableNotifications(string $workspaceID, string $type, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->where('type', $type)
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

    public function getActiveBannerScopedToWorkspace(string $workspaceID)
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->byBanner()
                    ->where('active', true)
                    ->first();
    }
}
