<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseFactory
{

    public function __construct(protected Model $model)
    {
    }

    public function create(array $request)
    {
        return $this->model->create($request);
    }

    public function update(array $update, ?string $whereCol = null, ?string $whereValue = null)
    {
        if (is_null($whereCol)) {
            return $this->builder->update($update);
        }

        return $this->builder->where($whereCol, $whereValue)->update($update);
    }

    public function updateWhere(string $col, string $value, array $updates)
    {
        return $this->model->where($col, $value)->update($updates);
    }



    public function remove(?array $ids = null, ?string $whereCol = null, ?string $whereValue = null)
    {
        if (is_null($ids) && is_null($whereCol)) {
            return $this->model->delete();
        }

        if (!is_null($whereCol)) {
            return $this->model->where($whereCol, $whereValue)->delete();
        }

        return $this->model->whereIn('id', collect($ids))->delete();
    }

    public function removeAllIDs(array $ids)
    {
        return $this->model->destroy($ids);
    }
}
