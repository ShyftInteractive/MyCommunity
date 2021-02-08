<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Admin;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Workspaces\Workspace;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Domain\Facades\Rebase\MemberRepository;

class Pick extends Controller
{
    public function __invoke(string $customerID, Request $request)
    {
        $allWorkspaces = Workspace::get();
        $workspaces = auth()->user()->workspaces;

        if ($workspaces->count() < 1) {
            $workspaces = $allWorkspaces;
        }

        return inertia(Action::getView($this), [
            'workspaces' => $workspaces->toArray(),
        ]);
    }
}
