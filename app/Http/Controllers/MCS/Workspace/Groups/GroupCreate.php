<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Http\Controllers\Controller;

class GroupCreate extends Controller
{
    public function __construct(private TagService $tagService) { }

    public function __invoke(Request $request)
    {
        $tags = $this->tagService->getItems();

        return inertia(Action::getView($this), [
            "tags" => $tags->toArray(),
        ]);
    }
}
