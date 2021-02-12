<?php declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Events\Event;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EventRepository extends BaseRepository
{

    public function __construct(Event $model)
    {
        parent::__construct(model: $model);
    }

    public function resource(array $item, string $workspaceID, string $memberID): array
    {
        return [
            "title" => $item['title'],
            "visibility" => $item['visibility'],
            'description' => $item['description'],
            "start_at" => Carbon::parse($item['start_at']),
            "end_at" => $item['end_at'] ? Carbon::parse($item['end_at']) : null,
            "workspace_id" => $workspaceID,
            "member_id" => $memberID,
        ];
    }

    public function getWorkspaceEventByID(string $workspaceID, string $eventID)
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->where('id', $eventID)
                    ->first();
    }

    public function getWorkspaceLatestEvents(string $workspaceID, int $count)
    {
        return $this->model
            ->byWorkspace($workspaceID)
            ->where('start_at', '>=', Carbon::now())
            ->orderBy('start_at')
            ->limit($count)
            ->get();
    }

}
