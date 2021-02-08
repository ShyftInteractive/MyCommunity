<?php

declare(strict_types=1);

namespace App\Domain\Tags;

use App\Domain\Models\MCS\Workspace\Tag;

class TagRepository extends BaseRepository
{

    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }
}
