<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Media;

class MediaIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $media = Media::byWorkspace($request->get('workspace_id'))->searchable(
            searchTerm: $request->get('s'),
            searchFields: ['name']
        )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'media' => $media->toArray(),
        ]);
    }
}
