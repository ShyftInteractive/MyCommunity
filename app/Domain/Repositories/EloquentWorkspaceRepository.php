<?php declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Models\Workspace;

class EloquentWorkspaceRepository extends EloquentRepository
{
    public function __construct(Workspace $model)
    {
        $this->model = $model;
    }
}
