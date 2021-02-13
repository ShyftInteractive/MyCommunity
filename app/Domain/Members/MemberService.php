<?php declare(strict_types=1);

namespace App\Domain\Members;

use Exception;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseService;
use App\Domain\Roles\RoleService;
use Illuminate\Support\Facades\Hash;
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

    public function createAsAccountOwner(string $workspaceID, array $item)
    {

        $member = $this->repository->create($this->repository->resource(
            item: $item
        ));

        $roleService = app()->make(RoleService::class);
        $roleService->makeAccountOwner(
            memberID: $member->id,
        );

        return $member;
    }

    public function isVerified(string $memberID, string $requestingMemberID, string $requestingToken, string $memberToken): bool
    {
        return $memberID === $requestingMemberID && $memberToken === $requestingToken;
    }

    public function verifyMember(array $items)
    {
        $member = $this->repository->getMemberByEmail(email: $items['email']);

        $isVerified = $this->isVerified(
            memberID: $member->id,
            requestingMemberID: $items['memberID'],
            requestingToken: $items['token'],
            memberToken: $member->email_token,
        );

        if (! $isVerified) {
            throw new Exception("Token Email Mismatch");
        }

        $this->updateItem(
            id: $member->id,
            updates: [
                'password' => Hash::make($items['password']),
                'email_token' => null,
                'email_verified_at' => Carbon::now(),
            ]
        );
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
