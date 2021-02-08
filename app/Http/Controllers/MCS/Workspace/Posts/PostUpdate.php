<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Domain\Posts\PostService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class PostUpdate extends Controller
{
    public function __construct(private PostService $postService) { }

    public function __invoke(string $postID, Request $request)
    {
        $this->postService->updatePost(
            workspaceID: $request->get('workspace_id'),
            memberID: auth()->user()->id,
            postID: $postID,
            post: $request->only('post')
        );

        return redirect()->back()->withSuccess('Saved');
    }
}
