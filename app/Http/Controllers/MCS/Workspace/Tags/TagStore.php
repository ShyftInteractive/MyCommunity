<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Tags;

use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Http\Controllers\Controller;

class TagStore extends Controller
{
    public function __construct(private TagService $tagService) {}

    public function __invoke(Request $request)
    {
        $this->tagService->createTag(
            workspaceID: $request->get('workspace_id'),
            name:$request->input('name'),
        );

        // Media::byWorkspace($request->get('workspace_id'))->with('tags')->where('id', $mediaID)->first()->tags()->attach($newTag);

        return redirect()->back();
    }
}
