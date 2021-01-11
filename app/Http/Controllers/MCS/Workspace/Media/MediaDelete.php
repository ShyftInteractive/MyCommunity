<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Media;

class MediaDelete extends Controller
{
    public function __invoke(string $mediaID, Request $request)
    {
        Media::destroy($mediaID);

        return redirect()->back()->with("success", "File Deleted");
    }
}
