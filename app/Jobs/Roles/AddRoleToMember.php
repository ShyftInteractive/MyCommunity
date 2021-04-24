<?php

namespace App\Jobs\Roles;

use App\Domain\Roles\Role;
use App\Enums\Rebase\MemberRoles;
use Illuminate\Foundation\Bus\Dispatchable;

class AddRoleToMember
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private string $memberID, private string $workspaceID, private string $roleType)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Role::updateorCreate(
            ['member_id' => $this->memberID, 'workspace_id' => $this->workspaceID],
            ['type' => MemberRoles::from($this->roleType)->getValue()]
        );
    }
}
