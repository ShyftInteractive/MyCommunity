<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupIndex extends Controller
{
    public function __construct(private GroupService $groupService, private TagService $tagService) { }

    public function __invoke(Request $request)
    {
        $tags = $this->tagService->getItems();
        $groups = $this->groupService->findGroup(
            workspaceID: $request->get('workspace_id'),
            search: $request->input('s'),
            count: $request->input('count'),
        );

        return inertia(Action::getView($this), [
            "groups" => $groups->toArray(),
            "tags" => $tags->toArray()
        ]);
    }
}
