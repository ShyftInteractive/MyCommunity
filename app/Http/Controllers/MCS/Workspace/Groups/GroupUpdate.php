<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupUpdate extends Controller
{
    public function __construct(private GroupService $groupService, private TagService $tagService) { }

    public function __invoke(string $groupID, Request $request)
    {
        $this->groupService->updateGroupWithTags(
            workspaceID: $request->get('workspace_id'),
            groupID: $groupID,
            group: $request->input(),
        );

        return redirect()->route('group.index')->with('success', 'Updated');
    }
}
