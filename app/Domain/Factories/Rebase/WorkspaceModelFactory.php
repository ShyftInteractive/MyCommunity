<?php

namespace App\Domain\Factories\Rebase;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Enums\Rebase\WorkspaceStatus;
use App\Domain\Models\Rebase\Workspace\Workspace;

class WorkspaceModelFactory extends ModelFactory
{
    public function __construct(Workspace $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function markAsVerified()
    {
        $this->update($this->model, [
            'status' => WorkspaceStatus::VERIFIED(),
            'activation_token' => null,
            'activation_at' => null,
        ]);

        return $this->model;
    }

    public function resetActivationToken(string $slug)
    {
        $this->update('slug', $slug, [
            'activation_token' => (string) Str::uuid(),
            'activation_at' => Carbon::now(),
        ]);

        return $this->model;
    }
}
