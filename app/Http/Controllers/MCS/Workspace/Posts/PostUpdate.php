<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class PostUpdate extends Controller
{
    public function __invoke(string $postID, Request $request)
    {
            $updateItems = collect($request->only([
                "post.id",
                "post.workspace_id",
                "post.member_id",
                "post.slug",
                "post.title",
                "post.description",
                "post.content",
                "post.visibility",
                "post.published_at",
            ]))->get('post');

        Post::modelFactory()->update(
            whereCol: 'id',
            whereValue: $postID,
            update: $updateItems
        );

        return redirect()->back()->withSuccess('Saved');
    }
}