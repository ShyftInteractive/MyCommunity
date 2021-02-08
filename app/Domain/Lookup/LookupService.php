<?php declare(strict_types=1);

namespace App\Domain\Lookup;

use App\Domain\Lookup\Lookup;
use App\Domain\Base\BaseService;
use App\Domain\Lookup\LookupRepository;

class LookupService extends BaseService {

    public function __construct(Lookup $model) {

        parent::__construct(
            repository: new LookupRepository($model)
        );
    }


}
