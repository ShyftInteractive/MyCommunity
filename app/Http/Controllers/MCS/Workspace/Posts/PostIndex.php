<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Posts\PostService;
use App\Http\Controllers\Controller;

class PostIndex extends Controller
{
    public function __construct(private PostService $postService) { }

    public function __invoke(Request $request)
    {
        $posts = $this->postService->findPosts(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );

        return inertia(Action::getView($this), [
            'posts' => $posts->toArray(),
        ]);
    }
}
