<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Domain\Media\MediaService;
use App\Http\Requests\MediaRequest;
use App\Http\Controllers\Controller;

class MediaStore extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function __invoke(MediaRequest $request)
    {
        $media = $this->mediaService->uploadAndSaveFile(
            customerID: $request->get('customer_id'),
            workspaceID: $request->get('workspace_id'),
            request: $request,
        );

        return $media->toJson();
    }
}
