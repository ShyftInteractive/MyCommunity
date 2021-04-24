<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Pages\PageService;
use App\Http\Controllers\Controller;

class PageIndex extends Controller
{
    public function __construct(private PageService $pageService) {}

    public function __invoke(Request $request)
    {

        $pages = $this->repository->searchInWorkspace(
            workspaceID: $request->get('workspace_id'),
            terms: $request->get('s'),
            fields: ['name'],
            count: (int) $request->get('count'),
        );

        return inertia(Action::getView($this), [
            'pages' => $pages->toArray(),
        ]);
    }
}
