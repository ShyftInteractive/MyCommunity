<?php declare(strict_types=1);

namespace App\Domain\Members;

use Exception;
use Illuminate\Http\Request;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseService;
use App\Domain\Roles\RoleService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function uploadMemberAvatar(string $customerID, string $workspaceID, string $memberID, Request $request)
    {
        $relativePath = "{$customerID}/{$workspaceID}/avatars";
        Storage::disk('spaces')->putFileAs($relativePath, $request->file, $request->avatarName, 'public');

        $fullPath = "{$relativePath}/{$request->avatarName}";

        return $this->repository->updateWhere(
            col: 'id',
            value: $memberID,
            updates: [
                'avatar' => Storage::disk('spaces')->url($fullPath),
            ]
        );
    }

    public function removeAvatar(string $memberID, string $workspaceID)
    {
        $member = $this->repository->getByID(id: $memberID);
        Storage::disk('spaces')->delete($member->avatar);

        return $this->repository->updateWhere(
            col: 'id',
            value: $memberID,
            updates: [
                'avatar' => null,
            ]
        );
    }

    public function updateMember(string $memberID, string $workspaceID, array $updates)
    {
        $member = $this->getWorkspaceMember(
            memberID: $memberID,
            workspaceID: $workspaceID,
        );

        $member->roles()->each(function($role) use ($workspaceID, $updates) {
            if ($role->workspace_id === $workspaceID && $updates['memberRole']['type'] !== $role->type) {
                $role->type = $updates['memberRole']['type'];
                $role->save();
            }
        });

        return $this->updateItem(
            id: $memberID,
            updates: $this->repository->resource($updates['member'])
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

    public function updateSelectedMembers(string $action, string $workspaceID, array $requests)
    {
        if ($action === 'activate-all' || $action === 'deactivate-all') {
            $ids = $this->repository->allMemberIds(workspaceID: $workspaceID)->flatMap(function($i) {
                return [$i->id];
            })->flatten()->toArray();
        }

        return match ($action) {
            'activate' => $this->repository->toggleActivation(ids: $requests['selected'], activate: true),
            'deactivate' => $this->repository->toggleActivation(ids: $requests['selected'],  activate: false),
            'activate-all' => $this->repository->toggleActivation(ids: $ids,  activate: true),
            'deactivate-all' => $this->repository->toggleActivation(ids: $ids,  activate: false),
            'delete' => $this->removeItems(ids: $requests['selected'])
        };
    }

    public function getWorkspaceMember(string $workspaceID, string $memberID)
    {
        $member = $this->repository->getWorkspaceMemberByID(
            workspaceID: $workspaceID,
            id: $memberID
        );

        $member->workspaceRoles = $member->roles->flatMap(function($item) {
            return [$item->workspace_id => $item];
        });

        return $member;
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

    public function getRoleForWorkspace(string $workspaceID, Member $member)
    {
        return $member->workspaceRoles->get($workspaceID);
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
