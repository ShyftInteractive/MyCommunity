<?php

namespace App\Jobs\Members;

use Illuminate\Http\Request;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Enums\Rebase\MemberRoles;
use App\Domain\Members\MemberRepository;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateNewMember
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private string $workspaceID, private array $items)
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
        $member = Member::create([
            'name' => $this->items['name'],
            'email' => $this->items['email'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $member->workspaces()->attach($this->workspaceID);
        $member->roles()->associate(
            ['type' => MemberRoles::ACCOUNT_OWNER()],
            ['member_id' => $member->id, ]
        );

        // Role::updateorCreate(
        //     ['member_id' => $otherMembers->id, 'workspace_id' => $workspace->id],
        //     ['type' => $this->generateRandomRole()]
        // );

        // $member->roles()->attach(MemberRoles::from($this->items['role'])->getValue(), ['workspace_id' => $this->workspaceID]);

        return $member;
    }
}
