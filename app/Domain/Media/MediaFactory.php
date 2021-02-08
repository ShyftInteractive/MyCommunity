<?php

namespace App\Domain\Media;

use App\Services\BaseFactory;
use App\Domain\Models\MCS\Workspace\Tag;
use App\Domain\Models\MCS\Workspace\Media;

class MediaFactory extends BaseFactory
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    public function attachTag(string $workspaceID, string $mediaID, Tag $newTag)
    {
        $this->model
            ->byWorkspace($workspaceID)
            ->with('tags')
            ->where('id', $mediaID)
            ->first()
            ->tags()
            ->attach($newTag);
    }
}
