<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use Illuminate\Http\Request;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupDelete extends Controller
{
    public function __construct(private GroupService $groupService) { }

    public function __invoke(string $groupID, Request $request)
    {
        $this->groupService->removeWorkspaceItem(
            workspaceID: $request->get('workspace_id'),
            id: $groupID,
        );

        return redirect()->back()->with(['success' => 'Deleted']);
    }
}
