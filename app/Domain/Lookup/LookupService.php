<?php declare(strict_types=1);

namespace App\Domain\Lookup;

use App\Domain\Lookup\Lookup;
use App\Domain\Base\BaseFactory;
use App\Domain\Base\BaseService;
use App\Domain\Lookup\LookupRepository;
use App\Exceptions\SubdomainLookupException;

class LookupService extends BaseService {

    public function __construct(Lookup $model) {

        parent::__construct(
            repository: new LookupRepository($model),
            factory: new BaseFactory($model)
        );
    }

    public function customerLoginExists(string $customerID, ?string $subdomain)
    {
        if (is_null($subdomain)) {
            $customerExists = $this->repository->customerIDExists(
                customerID: $customerID
            );
        } else {
            $customerExists = $this->repository->customerSubdomainExists(
                customerID: $customerID,
                subdomain: $subdomain,
            );
        }

        if (! $customerExists) {
            return throw new SubdomainLookupException('Unable to find sudbomain for customer');
        }

        return true;
    }
}
