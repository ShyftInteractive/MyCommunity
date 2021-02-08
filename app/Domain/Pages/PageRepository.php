<?php declare(strict_types=1);

namespace App\Domain\Pages;

use App\Domain\Models\MCS\Workspace\Page;

class PageRepository extends BaseRepository
{

    public function __construct(Page $model)
    {
        parent::__construct($model);
    }
}
