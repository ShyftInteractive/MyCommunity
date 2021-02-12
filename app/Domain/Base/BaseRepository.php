<?php declare(strict_types=1);

namespace App\Domain\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{

    public function __construct(protected Model $model) { }

    public function all(): Collection
    {
        return $this->model->get();
    }

    public function create(array $item)
    {
        return $this->model->create($item);
    }

    public function getByID(string $id): Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function getByIDScopedToWorkspace(string $id, string $workspaceID): Model
    {
        return $this->model->byWorkspace($workspaceID)->where('id', $id)->first();
    }

    public function updateWhere(string $col, string $value, array $updates)
    {
        return $this->model->where($col, $value)->update($updates);
    }

    public function deleteAll(string $col, array $values)
    {
        return $this->model->whereIn($col, collect($values))->delete();
    }

    public function delete(string $col, string $value)
    {
        return $this->model->where($col, $value)->first()->delete();
    }

    public function deleteScopedToWorkspace(string $col, string $value, string $workspaceID)
    {
        return $this->model->byWorkspace($workspaceID)->where($col, $value)->delete();
    }

    public function searchWorkspace(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

    public function search(?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
        return $this->model
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

}
