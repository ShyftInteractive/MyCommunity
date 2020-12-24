<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class PostIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::byWorkspace($request->get('workspace_id'))
            ->orderable(
                column: 'published_at',
            )->searchable(
                searchTerm: $request->get('s'),
                searchFields: ['title', 'slug']
            )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'posts' => $posts->toArray(),
        ]);
    }
}
