<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Page;
use App\Domain\Models\MCS\Workspace\Media;

class PageEdit extends Controller
{
    public function __invoke(string $pageID, Request $request)
    {
        return inertia(Action::getView($this), [
            'page' => Page::byID($pageID)->first(),
            'media' => Media::byWorkspace($request->get('workspace_id'))->get()
        ]);
    }
}
