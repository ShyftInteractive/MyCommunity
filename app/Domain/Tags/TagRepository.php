<?php declare(strict_types=1);

namespace App\Domain\Tags;

use App\Domain\Base\BaseRepository;

class TagRepository extends BaseRepository
{

    public function __construct(Tag $model)
    {
        parent::__construct(model: $model);
    }


}
