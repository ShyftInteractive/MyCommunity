<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use Dompdf\FrameDecorator\Page;
use App\Http\Controllers\Controller;

class PageIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $pages = Page::byWorkspace($request->get('workspace_id'))->searchable(
            searchTerm: $request->get('s'),
            searchFields: ['title', 'slug']
        )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'pages' => $pages->toArray(),
        ]);
    }
}
