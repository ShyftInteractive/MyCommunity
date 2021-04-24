<?php declare(strict_types=1);

namespace App\Domain\Members;

use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseRepository;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Support\Facades\Storage;

class MemberRepository extends BaseRepository
{

    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

    public function allMemberIds(string $workspaceID)
    {
        return $this->model
            ->with('roles')
            ->whereHas('workspaces', function($query) use($workspaceID) {
                $query->where('workspace_id', $workspaceID);
            })
            ->whereHas('roles', function($query) use($workspaceID) {
                $query->where('type', MemberRoles::WORKSPACE_OWNER())
                    ->orWhere('type', MemberRoles::WORKSPACE_ADMIN())
                    ->orWhere('type', MemberRoles::EDITOR())
                    ->orWhere('type', MemberRoles::ELEVATED())
                    ->orWhere('type', MemberRoles::MEMBER())
                    ->orWhere('type', MemberRoles::LIMITED())
                    ->orWhere('type', MemberRoles::PUBLIC_ACCESS());
            })
            ->get();
    }

    public function toggleActivation(array $ids, bool $activate = true)
    {
        return $this->model->whereIn('id', $ids)->update(['activated' => $activate]);
    }

    public function appendRolesRemapped($member)
    {
        return $member->roles->flatMap(function($item) {
            return [$item->workspace_id => $item->toArray()];
        });
    }


    public function getMemberByEmail(string $email)
    {
        return $this->model
                    ->where('email', $email)
                    ->firstOrFail();
    }

    public function getWorkspaceMemberByID(string $workspaceID, string $id)
    {
        return $this->model
                    ->with('roles')
                    ->whereHas('workspaces', function($query) use($workspaceID) {
                        $query->where('workspace_id', $workspaceID);
                    })
                    ->where("id", $id)
                    ->first();
    }

    public function resource(array $item, ?string $relativePath = null)
    {
        return [
            'name' => $item['name'],
            'email' => $item['email'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function searchableMembers(string $workspaceID, ?string $terms = null, ?array $fields = null, ?int $count, string $orderBy = 'created_at', string $orderDirection = 'asc')
    {
       return $this->model
                    ->with('roles')
                    ->whereHas('workspaces', function($query) use($workspaceID) {
                            $query->where('workspace_id', $workspaceID);
                    })
                    ->byUserSearch(terms: $terms, fields: $fields)
                    ->orderBy($orderBy, $orderDirection)
                    ->paginate($count ?? 10);

    }
}
