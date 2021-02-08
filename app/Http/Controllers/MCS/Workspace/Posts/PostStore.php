<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Domain\Posts\PostService;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostStore extends Controller
{
    public function __construct(private PostService $postService) { }

    public function __invoke(PostRequest $request)
    {

        $post = $this->postService->createPost(
            memberID: auth()->user()->id,
            workspaceID: $request->get('workspace_id'),
            request: $request->input(),
        );

        return redirect()->route('post.edit', [
            'postID' => $post->id,
        ]);
    }
}
