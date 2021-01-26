<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseQueries
{

    public function __construct(public Model $model, public array $scopes = [])
    {
    }

    public function getBySub(string $sub): Model
    {
        return $this->model->where('sub', $sub)->first();
    }

    public function getByID(string $id): Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function getByWorkspaceID(string $workspaceID): Collection
    {
        return $this->model->where('workspace_id', $workspaceID)->get();
    }
}
