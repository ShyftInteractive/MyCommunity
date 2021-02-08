<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Tags\TagService;
use App\Domain\Media\MediaService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Tag;

class MediaIndex extends Controller
{
    public function __construct(private MediaService $mediaService, private TagService $tagService)
    {
    }

    public function __invoke(Request $request)
    {
        $media = $this->mediaService->findMediaAndTags(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );

        $tags = $this->tagService->getItems();

        return inertia(Action::getView($this), [
            'media' => $media->toArray(),
            'tags' => $tags->toArray(),
        ]);
    }
}
