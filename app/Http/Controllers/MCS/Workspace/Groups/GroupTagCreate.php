<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupTagCreate extends Controller
{
    public function __construct(private TagService $tagService, private GroupService $groupService) {}

    public function __invoke(string $groupID, Request $request)
    {
        $tag = $this->tagService->createTag(
            workspaceID: $request->get('workspace_id'),
            name:$request->input('name'),
        );

        $this->groupService->createTagForGroup(
            workspaceID: $request->get('workspace_id'),
            groupID: $groupID,
            tag: $tag,
        );

        return redirect()->back();
    }
}
