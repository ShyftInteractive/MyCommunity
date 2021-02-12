<?php declare(strict_types=1);

namespace App\Domain\Groups;

use App\Domain\Base\BaseRepository;

class GroupRepository extends BaseRepository
{

    public function __construct(Group $model)
    {
        parent::__construct(model: $model);
    }

    public function resource(array $item, string $workspaceID): array
    {
        return [
            "name" => $item['name'],
            "workspace_id" => $workspaceID,
        ];
    }

    public function searchGroupWithTags(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->with('tags')
                    ->byWorkspace($workspaceID)
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

    public function getGroupWithTags(string $workspaceID, string $groupID)
    {
        return $this->model
                    ->with('tags')
                    ->byWorkspace($workspaceID)
                    ->where('id', $groupID)
                    ->first();
    }

    public function mapToIDs(array $tags)
    {
        return collect($tags)->map(function($item) {
            return $item['id'];
        });
    }

    public function syncTags(Group $model, array $tags, array $existingTags = [])
    {
        $model->tags()->sync(
            collect($tags)->flatMap(function($item) use($model) {
                return [$item['id'] => ['workspace_id' => $model->workspace_id]];
            })->toArray()
        );
    }

    public function workspaceGroupAndTagUpdate(string $workspaceID, string $groupID, string $name, array $tags)
    {
        $model = $this->model->with('tags')->byWorkspace($workspaceID)->where('id', $groupID)->first();
        $model->name = $name;
        $model->save();

        $this->syncTags($model, $tags);
    }

}
