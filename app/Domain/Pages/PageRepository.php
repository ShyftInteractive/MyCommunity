<?php declare(strict_types=1);

namespace App\Domain\Pages;

use App\Domain\Pages\Page;
use App\Domain\Base\BaseRepository;

class PageRepository extends BaseRepository
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }


}
