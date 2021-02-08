<?php declare(strict_types=1);

namespace App\Domain\Posts;

use App\Domain\Models\MCS\Workspace\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends BaseRepository
{

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function searchable(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy('published_at', 'asc')
                    ->orderBy('created_at', 'asc')
                    ->paginate($count ?? 10);
    }

}
