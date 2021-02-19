<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;

class MemberStore extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(Request $request) {

        $member = $this->memberService->createMember(

            workspaceID: $request->get('workspace_id'),
            updates: $request->input(),
        );


        return redirect()->route('member.index')->with('success', "Member Created");

    }
}
