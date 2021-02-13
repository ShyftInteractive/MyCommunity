<?php declare(strict_types=1);

namespace App\Domain\Members;

use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Domain\Base\BaseRepository;

class MemberRepository extends BaseRepository
{

    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

    public function resource(array $item)
    {
        return [
            'name' => $item['name'],
            'email' => $item['email'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
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
