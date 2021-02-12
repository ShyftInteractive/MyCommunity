<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Domain\Media\MediaService;
use App\Http\Controllers\Controller;

class MediaDelete extends Controller
{
    public function __construct(private MediaService $mediaService) { }

    public function __invoke(string $mediaID, Request $request)
    {
        $this->mediaService->removeItems(ids: [$mediaID]);

        return redirect()->back()->with("success", "File Deleted");
    }
}
