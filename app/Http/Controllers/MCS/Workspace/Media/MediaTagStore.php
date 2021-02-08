<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Services\MCS\TagService;
use App\Services\MCS\MediaService;
use App\Http\Controllers\Controller;

class MediaTagStore extends Controller
{
    public function __construct(private TagService $tagService, private MediaService $mediaService)
    {
    }
    public function __invoke(string $mediaID, string $type, string $tagID, Request $request)
    {
        $newTag = $this->tagService->createNewTag(
            workspaceID: $request->get('workspace_id'),
            name: $request->get('name'),
        );

        $this->mediaService->addTagToMedia(
            workspaceID: $request->get('workspace_id'),
            mediaID: $mediaID,
            newTag: $newTag,
        );

        return redirect()->back();
    }
}
