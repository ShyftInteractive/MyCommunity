<?php declare(strict_types=1);

namespace App\Domain\Media;

use App\Domain\Media\Media;
use App\Domain\Base\BaseRepository;

class MediaRepository extends BaseRepository
{

    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    public function allAndTags(string $workspaceID)
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->with('tags')
                    ->get();
    }

    public function getWithTags(string $workspaceID, string $mediaID)
    {
        return $this->model
                    ->with('tags')
                    ->byWorkspace($workspaceID)
                    ->where('id', $mediaID)
                    ->first();
    }

    public function searchable(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->with('tags')
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }
}
