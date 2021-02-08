<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Tags;

use Illuminate\Http\Request;
use App\Services\MCS\TagService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Tag;
use App\Domain\Models\MCS\Workspace\Media;

class TagStore extends Controller
{
    public function __invoke(string $mediaID, Request $request)
    {

        $newTag = Tag::create([
            'workspace_id' => $request->get('workspace_id'),
            'name' => $request->get('name')
        ]);

        Media::byWorkspace($request->get('workspace_id'))->with('tags')->where('id', $mediaID)->first()->tags()->attach($newTag);

        return redirect()->back();
    }
}
