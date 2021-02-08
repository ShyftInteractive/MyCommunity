<?php

namespace App\Domain\Pages;

use App\Services\BaseFactory;
use App\Domain\Models\MCS\Workspace\Page;

class PageFactory extends BaseFactory
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function updateHomepage(string $workspaceID, string $newHomepage)
    {
        $homepage = $this->model
            ->byWorkspace($workspaceID)
            ->where('is_homepage', true)
            ->first();

        if ($homepage->slug !== $newHomepage) {
            $homepage->is_homepage = false;
            $homepage->save();

            $this->model->byWorkspace($workspaceID)->where('slug', $newHomepage)->update('is_homepage', true);
        }
    }
}
