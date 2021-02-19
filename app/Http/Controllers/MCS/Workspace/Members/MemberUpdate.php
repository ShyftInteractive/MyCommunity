<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;

class MemberUpdate extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, Request $request)
    {
        $member = $this->memberService->updateMember(
            memberID: $memberID,
            workspaceID: $request->get('workspace_id'),
            updates: $request->input(),
        );


        return redirect()->route('member.index')->with('success', "Member Updated");
    }
}
