<?php

declare(strict_types=1);

namespace App\Domain\Groups;

use App\Domain\Groups\Group;
use App\Domain\Base\BaseRepository;

class GroupRepository extends BaseRepository
{

    public function __construct(Group $model)
    {
        parent::__construct($model);
    }
}
