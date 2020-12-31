<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class PostEdit extends Controller
{
    public function __invoke(string $postID, Request $request)
    {
        return inertia(Action::getView($this), [
            'post' => Post::byID($postID)->first()
        ]);
    }
}
