<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Post;

class PostStore extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $post = Post::modelFactory()->create([
            "slug" => $request->input('slug'),
            "title" => $request->input('title'),
            "content" => "<h1>Start typin'....</h1>",
            "visibility" => $request->input('visibility'),
            "workspace_id" => $request->get('workspace_id'),
            "member_id" => auth()->user()->id,
        ]);

        return redirect()->route('post.edit', [
            'postID' => $post->id,
        ]);
    }

    private function rules(string $workspaceID): array
    {
        return [
            'title' => ['string', 'required', 'max:100'],
            'slug' => ['string', 'required', 'max:100', Rule::unique('workspace.posts')->where('workspace_id', $workspaceID)],
            'visibility' => ['required'],
        ];
    }
}
