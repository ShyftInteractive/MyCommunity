<?php

namespace App\Pipelines\Registration;

use Illuminate\Support\Facades\Artisan;
use App\Domain\Workspaces\WorkspaceService;

class CreateWorkspace
{
    public function __invoke($payload)
    {
        $exitCode = Artisan::call('migrate:workspaces', [
            'customerID' => $payload->get('customer')->id
        ]);

        if (0 !== $exitCode) {
            return false;
        }

        return $payload;
    }
}
