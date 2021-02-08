<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use App\Domain\Media\Media;
use Illuminate\Http\Request;
use Dompdf\FrameDecorator\Page;
use App\Http\Controllers\Controller;

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
