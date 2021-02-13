<?php declare(strict_types=1);

namespace App\Domain\Roles;

use App\Domain\Base\BaseRepository;

class RoleRepository extends BaseRepository
{

    public function __construct(Role $model)
    {
        parent::__construct(model: $model);
    }

    public function giveRole (?string $workspaceID = null, string $memberID, string $role)
    {
        $this->model->create([
            'type' => $role,
            'member_id' => $memberID
        ]);
    }

}
