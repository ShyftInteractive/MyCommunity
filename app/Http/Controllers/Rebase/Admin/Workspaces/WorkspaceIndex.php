<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Admin\Workspaces;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Workspaces\Workspace;
use App\Http\Controllers\Controller;

class WorkspaceIndex extends Controller
{
    public function __invoke(string $customerID, Request $request)
    {
        $workspaces = Workspace::searchable(
            searchTerm: $request->get('s'),
            searchFields: ['name', 'sub']
        )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'workspaces' => $workspaces->toArray(),
        ]);
    }
}
