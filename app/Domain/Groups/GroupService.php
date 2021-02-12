<?php declare(strict_types=1);

namespace App\Domain\Groups;

use App\Domain\Tags\Tag;
use App\Domain\Base\BaseService;
use App\Domain\Tags\TagService;

class GroupService extends BaseService {

    private $tagModel;

    public function __construct(Group $model, Tag $tagModel) {

        $this->tagModel = $tagModel;

        parent::__construct(
            repository: new GroupRepository($model)
        );
    }

    public function findGroup(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository
            ->searchGroupWithTags(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['name'],
                orderBy: 'created_at',
                count: $count
            );
    }

    public function createGroupWithTags(string $workspaceID, array $item)
    {
        $group = $this->repository->create($this->repository->resource(
            workspaceID: $workspaceID,
            item: $item
        ));

        $tagService = new TagService($this->tagModel);
        $tags = $tagService->mapNamesToTags(
            workspaceID: $workspaceID,
            tags: $item['tags']
        );

        $this->repository->syncTags(
            model: $group,
            tags: $tags
        );
    }

    public function createTagForGroup(string $workspaceID, string $groupID, Tag $tag)
    {
        $group = $this->repository->getGroupWithTags(
            workspaceID: $workspaceID,
            groupID: $groupID,
        );

        $this->repository->syncTags(
            model: $group,
            tags: array_merge($group->tags->toArray(), [$tag])
        );
    }

    public function updateGroupWithTags(string $workspaceID, string $groupID, array $group)
    {
        return $this->repository->workspaceGroupAndTagUpdate(
            workspaceID: $workspaceID,
            groupID: $groupID,
            name: $group['name'],
            tags: $group['tags'],
        );
    }

    public function getGroupWithTags(string $workspaceID, string $groupID)
    {
        return $this->repository->getGroupWithTags(
            workspaceID: $workspaceID,
            groupID: $groupID,
        );
    }
}
