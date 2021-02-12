<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupEdit extends Controller
{
    public function __construct(private GroupService $groupService, private TagService $tagService) { }

    public function __invoke(string $groupID, Request $request)
    {
        $tags = $this->tagService->getItems();
        $group = $this->groupService->getGroupWithTags(
            groupID: $groupID,
            workspaceID: $request->get('workspace_id')
        );

        return inertia(Action::getView($this), [
            'group' => $group,
            'tags' => $tags->toArray()
        ]);
    }
}
