<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;

class MemberIndex extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(Request $request)
    {
        $members = $this->memberService->findWorkspaceMembers(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );

        return inertia(Action::getView($this), [
            'members' => $members->toArray(),
        ]);
    }
}
