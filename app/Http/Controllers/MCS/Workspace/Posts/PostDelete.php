<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class PostDelete extends Controller
{
    public function __invoke(string $postID, Request $request)
    {
        Post::modelFactory()->remove(ids: [$postID]);

        return redirect()->back()->with(['success' => 'Post Deleted']);
    }

}
