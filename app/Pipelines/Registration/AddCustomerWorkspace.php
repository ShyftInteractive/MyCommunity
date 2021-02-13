<?php

namespace App\Pipelines\Registration;

use Illuminate\Support\Facades\Artisan;
use App\Domain\Workspaces\WorkspaceService;

class AddCustomerWorkspace
{
    public function __invoke($payload)
    {
        $workspaceService = app()->make(WorkspaceService::class);
        $workspace = $workspaceService->createWorkspace(item: $payload->toArray());

        $payload->put('workspace', $workspace);

        return $payload;
    }
}
