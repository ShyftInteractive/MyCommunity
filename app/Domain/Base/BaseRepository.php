<?php declare(strict_types=1);

namespace App\Domain\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseRepository
{

    public function __construct(protected Model $model) { }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->get();
    }

    /**
     * @param string $id
     * @return Model
     */
    public function getByID(string $id): Model
    {
        return $this->model
                    ->where('id', $id)
                    ->first();
    }

    /**
     * @param string $id
     * @param string $workspaceID
     * @return Model
     */
    public function getByIDInWorkspace(string $id, string $workspaceID): Model
    {
        return $this->model
                    ->byWorkspace($workspaceID
                    )->where('id', $id)
                    ->first();
    }

    /**
     * @param string $workspaceID
     * @param string|null $terms
     * @param array|null $fields
     * @param integer|null $count
     * @param string $orderBy
     * @param string $orderDirection
     * @return LengthAwarePaginator
     */
    public function searchInWorkspace(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc'): LengthAwarePaginator
    {
        return $this->model
                    ->byWorkspace($workspaceID)
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

    /**
     * @param string|null $terms
     * @param array|null $fields
     * @param integer|null $count
     * @param string $orderBy
     * @param string $orderDirection
     * @return LengthAwarePaginator
     */
    public function search(?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc'): LengthAwarePaginator
    {
        return $this->model
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);
    }

}
