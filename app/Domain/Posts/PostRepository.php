<?php declare(strict_types=1);

namespace App\Domain\Posts;

use App\Domain\Posts\Post;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends BaseRepository
{

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function resource(array $item, string $workspaceID, string $memberID): array
    {
        return [
            'workspace_id' => $workspaceID,
            "slug" => $item['slug'],
            "title" => $item['title'],
            "content" => $item['content'] ?? "<h1>Start Writing Here</h1>",
            "visibility" => $item['visibility'],
            "workspace_id" => $workspaceID,
            "description" => isset($item["description"]) ? $item["description"] : null,
            "published" => isset($item["published"]) ? $item["published"] : false,
            "published_at" => isset($item['published_at']) ? Carbon::parse($item['published_at']) : null,
            "member_id" => $memberID,
        ];
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
