<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Front;

use App\Actions\Action;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class Index extends Controller
{
    public function __invoke(Request $request, string $page = '')
    {
        $page = $this->getWorkspaceStoragePath($request) .'.'.str_replace('/', '.', $page);

        try {
            return view($page);
        } catch (InvalidArgumentException $e) {
            return abort(404);
        }

    }

    private function getWorkspaceStoragePath($request)
    {
        return "customers.data.{$request->get('customer_id')}.{$request->get('workspace_id')}";
    }
}
