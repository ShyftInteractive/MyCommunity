<?php declare(strict_types=1);

namespace App\Domain\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseFactory
{

    public function __construct(protected Model $model) { }


    public function create(array $item)
    {
        return $this->model->create($item);
    }

    public function updateWhere(string $col = 'id', string $value, array $updates)
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

}
