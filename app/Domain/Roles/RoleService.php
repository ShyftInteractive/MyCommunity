<?php declare(strict_types=1);

namespace App\Domain\Roles;

use App\Domain\Roles\Role;
use App\Domain\Base\BaseService;
use App\Domain\Roles\RoleRepository;
use App\Enums\Rebase\MemberRoles;

class RoleService extends BaseService {

    public function __construct(Role $model) {

        parent::__construct(
            repository: new RoleRepository($model)
        );
    }

    public function makeAccountOwner(string $memberID)
    {
        return $this->repository->giveRole(
            memberID: $memberID,
            role: MemberRoles::ACCOUNT_OWNER()->getValue(),
        );
    }
}
