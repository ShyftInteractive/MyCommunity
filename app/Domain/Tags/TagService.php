<?php declare(strict_types=1);

namespace App\Domain\Tags;

use App\Domain\Base\BaseFactory;
use App\Domain\Base\BaseService;
use App\Domain\Tags\TagRepository;

class TagService extends BaseService {

    public function __construct(Tag $model) {

        parent::__construct(
            repository: new TagRepository($model),
            factory: new BaseFactory($model),
        );
    }

    public function createTag(string $workspaceID, string $name)
    {
        return $this->factory->create([
            "workspace_id" => $workspaceID,
            "name" => $name,
        ]);
    }

    public function mapNamesToTags(string $workspaceID, array $tags)
    {
        return collect($tags)->map(function ($tag) use ($workspaceID) {
            if (isset($tag['id'])) {
                return $tag;
            }

            return $this->repository->getTagByNameScopedByWorkspace(
                workspaceID: $workspaceID,
                name: $tag['name'],
            )->toArray();

        })->toArray();
    }

}
