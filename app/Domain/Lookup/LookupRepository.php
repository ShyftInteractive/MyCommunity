<?php declare(strict_types=1);

namespace App\Domain\Lookup;

use App\Domain\Lookup\Lookup;
use App\Domain\Base\BaseRepository;

class LookupRepository extends BaseRepository
{

    public function __construct(Lookup $model)
    {
        parent::__construct(model: $model);
    }
}
