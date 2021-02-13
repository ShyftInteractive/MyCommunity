<?php declare(strict_types=1);

namespace App\Domain\BannedSubdomains;

use App\Domain\Base\BaseService;

class BannedSubdomainService extends BaseService {

    public function __construct(BannedSubdomain $model) {

        parent::__construct(
            repository: new BannedSubdomainRepository($model)
        );
    }

    public function subdomainBanned(string $name)
    {
        return $this->repository->subdomainExists(sub: $name);
    }
}
