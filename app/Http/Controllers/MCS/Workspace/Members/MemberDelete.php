<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;
use App\Exceptions\SelfRemovalException;
use App\Exceptions\AccountRemovalException;

class MemberDelete extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, Request $request)
    {
        try {
            $this->memberService->removeMemberFromWorkspace(
                workspaceID: $request->get('workspace_id'),
                activeUser: auth()->user()->id,
                memberID: $memberID,
            );
        } catch(SelfRemovalException|AccountRemovalException $e) {
            return redirect()->back()->with(['alert' => $e->getMessage()]);
        }

        return redirect()->back()->with(['success' => 'Member Removed']);
    }
}
