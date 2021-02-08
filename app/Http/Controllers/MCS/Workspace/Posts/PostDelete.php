<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use Illuminate\Http\Request;
use App\Domain\Posts\PostService;
use App\Http\Controllers\Controller;

class PostDelete extends Controller
{
    public function __construct(private PostService $postService) { }

    public function __invoke(string $postID, Request $request)
    {
        $this->postService->removeItems(ids: [$postID]);

        return redirect()->back()->with(['success' => 'Post Deleted']);
    }

}
