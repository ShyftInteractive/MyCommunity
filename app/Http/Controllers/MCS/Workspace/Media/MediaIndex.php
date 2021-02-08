<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Services\MCS\MediaService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Tag;
use App\Domain\Models\MCS\Workspace\Media;

class MediaIndex extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function __invoke(Request $request)
    {

        $media = $this->mediaService->findMediaAndTags(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );


        return inertia(Action::getView($this), [
            'media' => $media->toArray(),
            'tags' => Tag::get()->toArray(),
        ]);
    }
}
