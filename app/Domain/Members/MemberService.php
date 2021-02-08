<?php declare(strict_types=1);

namespace App\Domain\Members;

use App\Domain\Members\Member;
use App\Domain\Base\BaseService;
use App\Enums\Rebase\MemberRoles;
use App\Domain\Factories\BaseFactory;
use App\Domain\Members\MemberRepository;
use App\Exceptions\SelfRemovalException;
use App\Exceptions\AccountRemovalException;

class MemberService extends BaseService
{

    public function __construct(Member $model)
    {
        parent::__construct(
            repository: new MemberRepository($model),
        );
    }

    public function resource(array $items, string $workspaceID)
    {
        return [ ];
    }

    public function getWorkspaceMember(string $workspaceID, string $memberID)
    {
        return $this->repository->getWorkspaceMemberByID(
            workspaceID: $workspaceID,
            id: $memberID
        );
    }

    public function removeMemberFromWorkspace(string $memberID, string $activeUser, string $workspaceID)
    {
        if ($memberID === $activeUser) {
            return throw new SelfRemovalException("You cannot remove yourself");
        }

        $member = $this->getWorkspaceMember(
            workspaceID: $workspaceID,
            memberID: $memberID,
        );

        if ($member->roles->isExecutiveOrAccount()) {
            return throw new AccountRemovalException("You cannot remove an account team member or website owner");
        }

        return $member->workspaces()->sync($member->workspaces->except([$workspaceID]));
    }

    public function findWorkspaceMembers(string $workspaceID, ?string $search, ?int $count)
    {
        return $this->repository->searchableMembers(
                workspaceID: $workspaceID,
                terms: $search,
                fields: ['name', 'email'],
                orderBy: 'name',
                count: $count
        );
    }
}
