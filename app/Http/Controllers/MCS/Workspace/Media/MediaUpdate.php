<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Domain\Media\MediaService;
use App\Http\Controllers\Controller;

class MediaUpdate extends Controller
{

    public function __construct(private MediaService $mediaService) { }

    public function __invoke(string $mediaID, Request $request)
    {
        $this->mediaService->updateMediaTags(
            workspaceID: $request->get('workspace_id'),
            mediaID: $mediaID,
            media: $request->input(),
        );

        return redirect()->back();
    }
}
