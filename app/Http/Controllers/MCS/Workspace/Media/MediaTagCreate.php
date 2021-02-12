<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Media\MediaService;
use App\Http\Controllers\Controller;

class MediaTagCreate extends Controller
{
    public function __construct(private TagService $tagService, private MediaService $mediaService)
    {
    }
    public function __invoke(string $mediaID, Request $request)
    {
        $tag = $this->tagService->createTag(
            workspaceID: $request->get('workspace_id'),
            name:$request->input('name'),
        );

        $this->mediaService->createTagForMedia(
            mediaID: $mediaID,
            tag: $tag,
            workspaceID: $request->get('workspace_id'),
        );

        return redirect()->back();
    }
}
