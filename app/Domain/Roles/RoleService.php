<?php declare(strict_types=1);

namespace App\Domain\Roles;

use App\Domain\Roles\Role;
use App\Domain\Base\BaseFactory;
use App\Domain\Base\BaseService;
use App\Enums\Rebase\MemberRoles;
use App\Domain\Roles\RoleRepository;

class RoleService extends BaseService {

    public function __construct(Role $model) {

        parent::__construct(
            repository: new RoleRepository($model),
            factory: new BaseFactory($model),
        );
    }

    public function makeAccountOwner(string $memberID)
    {
        return $this->repository->giveRole(
            memberID: $memberID,
            role: MemberRoles::ACCOUNT_OWNER()->getValue(),
        );
    }

    public function attachAs(string $memberID, string $role)
    {
        return $this->repository->giveRole(
            memberID: $memberID,
            role: MemberRoles::from($role)->getValue(),
        );
    }
}
