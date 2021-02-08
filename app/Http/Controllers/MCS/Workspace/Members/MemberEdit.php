<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;
use App\Domain\Facades\Rebase\MemberRepository;
use App\Domain\Facades\Rebase\WorkspaceRepository;

class MemberEdit extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, Request $request)
    {
        $member = $this->memberService->getWorkspaceMember(
            workspaceID: $request->get('workspace_id'),
            memberID: $memberID,
        );

        return inertia(Action::getView($this), [
            'member' => $member,
        ]);
    }
}
