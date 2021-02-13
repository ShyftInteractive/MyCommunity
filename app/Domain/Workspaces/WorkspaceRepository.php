<?php declare(strict_types=1);

namespace App\Domain\Workspaces;

use App\Domain\Base\BaseRepository;
use App\Domain\Workspaces\Workspace;

class WorkspaceRepository extends BaseRepository
{

    public function __construct(Workspace $model)
    {
        parent::__construct(model: $model);
    }

    public function resource(string $customerID, array $item)
    {
        return [
            'customer_id' => $customerID,
            'name' => $item['customer']['name'],
            'sub' => $item['sub'],
        ];
    }
}
