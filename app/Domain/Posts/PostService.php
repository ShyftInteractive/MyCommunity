<?php declare(strict_types=1);

namespace App\Domain\Posts;

use App\Domain\Base\BaseFactory;
use App\Domain\Posts\Post;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseService;
use App\Domain\Posts\PostRepository;

class PostService extends BaseService
{
    public function __construct(Post $model)
    {
        parent::__construct(
            repository: new PostRepository($model),
            factory: new BaseFactory($model),
        );
    }

    public function createPost(array $request, string $workspaceID, string $memberID)
    {
        return $this->factory->create($this->repository->resource(
            workspaceID: $workspaceID,
            memberID: $memberID,
            item: $request,
        ));
    }

    public function updatePost(string $workspaceID, string $memberID, string $postID, array $post)
    {
        return $this->factory->updateWhere(
            col: 'id',
            value: $postID,
            updates: $this->repository->resource(
                item: $post['post'],
                workspaceID: $workspaceID,
                memberID: $memberID
            )
        );
    }

    public function getPost(string $workspaceID, string $postID)
    {
        return $this->repository->getByIDInWorkspace(
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
