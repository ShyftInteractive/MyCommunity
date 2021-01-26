<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Media;

class MediaUpdate extends Controller
{
    public function __invoke(string $mediaID, Request $request)
    {
        // Media::with('tags')->where('id', $mediaID)->update($request->only(
        //     "id",
        //     "workspace_id",
        //     "name",
        //     "path",
        //     "url",
        //     "type",
        //     "visibility",
        //     "archive",
        // ));


        $media = Media::with('tags')->where('id', $mediaID)->first();
        $tagIDs = collect($request->input('tags'))->map(function ($tag) {
            return $tag['id'];
        })->toArray();

        $media->tags()->sync($tagIDs);

        return redirect()->back();
    }
}
