<?php declare(strict_types=1);

namespace App\Pipelines\Registration;

use App\Domain\Members\MemberService;

class AddFirstMemberToWorkspace
{
    public function __invoke($payload)
    {
        $memberService = app()->make(MemberService::class);

        $member = $memberService->createAsAccountOwner(
            workspaceID: $payload->get('workspace')->id,
            item: $payload->toArray(),
        );

        $payload->put('member', $member);

        return $payload;
    }
}
