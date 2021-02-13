<?php declare(strict_types=1);

namespace App\Domain\Workspaces;

use App\Domain\Base\BaseService;
use App\Domain\Workspaces\Workspace;
use App\Domain\Workspaces\WorkspaceRepository;

class WorkspaceService extends BaseService {

    public function __construct(Workspace $model) {

        parent::__construct(
            repository: new WorkspaceRepository($model)
        );
    }

    public function createWorkspace(array $item)
    {
        return  $this->repository->create($this->repository->resource(
            customerID: $item['customer']['id'],
            item: $item,
        ));
    }


}
