<?php declare(strict_types=1);

namespace App\Domain\Posts;

use App\Services\BaseService;
use Illuminate\Support\Carbon;
use App\Domain\Factories\BaseFactory;
use App\Domain\Models\MCS\Workspace\Post;
use App\Domain\Repositories\PostRepository;

class PostService extends BaseService
{
    public function __construct(Post $model)
    {
        parent::__construct(
            repository: new PostRepository($model),
            factory: new BaseFactory($model)
        );
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

    public function createPost(array $request, string $workspaceID, string $memberID)
    {
        return $this->factory->store($this->resource(
            workspaceID: $workspaceID,
            memberID: $memberID,
            item: $request,
        ));
    }

    public function updatePost(string $workspaceID, string $memberID, string $postID, array $post)
    {
        return $this->factory->updateByID(
            id: $postID,
            updates: $this->resource(
                item: $post['post'],
                workspaceID: $workspaceID,
                memberID: $memberID
            )
        );
    }

    public function getPost(string $workspaceID, string $postID)
    {
        return $this->repository->getWorkspaceItemByID(
            workspaceID: $workspaceID,
            id: $postID,
        );
    }

    public function findPosts(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
            ->searchable(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['title', 'description'],
                orderBy: 'start_at',
                count: $count
            );
    }
}
