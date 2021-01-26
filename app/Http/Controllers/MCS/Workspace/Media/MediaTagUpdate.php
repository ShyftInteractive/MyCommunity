<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaTagUpdate extends Controller
{
    public function __invoke(string $mediaID, string $type, string $tagID, Request $request)
    {
    }
}
