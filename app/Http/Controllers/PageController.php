<?php
namespace App\Http\Controllers;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Pages\PageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Domain\Pages\PageService;

class PageController extends Controller
{
    protected  $viewLocation = '/Pages/MCS/Workspace/Pages';

    public function __construct(protected PageRepository $repository,
                                protected PageService $pageService) { }

    public function index(Request $request)
    {
        $pages = $this->repository->searchInWorkspace(
            workspaceID: $request->get('workspace_id'),
            terms: $request->get('s'),
            fields: ['name'],
            count: (int) $request->get('count'),
        );

        return $this->getInertiaView(
            name: 'PageIndex',
            props: [
                'pages' => $pages->toArray()
            ]
        );
    }

    public function create()
    {
    }

    public function edit(string $memberID, Request $request)
    {
    }

    public function update(string $memberID, Request $request)
    {
    }

    public function store(Request $request)
    {
    }

    public function upload(string $memberID, AvatarRequest $request)
    {
    }

    public function uploadDelete(string $memberID, Request $request)
    {
    }

    public function selected(string $action, Request $request)
    {
    }

    public function destroy(string $memberID, Request $request)
    {
    }
}
