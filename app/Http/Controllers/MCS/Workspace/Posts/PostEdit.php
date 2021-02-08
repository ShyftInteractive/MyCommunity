<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Posts\PostService;
use App\Http\Controllers\Controller;

class PostEdit extends Controller
{
    public function __construct(private PostService $postService) { }

    public function __invoke(string $postID, Request $request)
    {
        $post = $this->postService->getPost(
            postID: $postID,
            workspaceID: $request->get('workspace_id'),
        );

        return inertia(Action::getView($this), [
            'post' => $post
        ]);
    }
}
