<?php declare(strict_types=1);

namespace App\Domain\Customers;

use App\Domain\Base\BaseService;
use App\Domain\Customers\CustomerRepository;

class CustomerService extends BaseService {

    public function __construct(Customer $model) {

        parent::__construct(
            repository: new CustomerRepository($model)
        );
    }

    public function createCustomer(array $item)
    {
        return $this->repository->create($this->repository->resource(item: $item));
    }

    public function chargeCustomer(Customer $customer, array $item)
    {
        if ($item['payment_type'] == 'cc') {
            return $this->repository->subscribe(
                customer: $customer,
                plan: $item['plan'],
                method: $item['payment_method'],
                options: [
                    'name' => $customer->name,
                    'email' => $item['email'],
                    'address' => [
                        'line1' => $item['line1'],
                        'line2' => $item['line2'],
                        'city' => $item['city'],
                        'state' => $item['state'],
                        'postal_code' => $item['postal_code'],
                    ],
                ]
            );
        }
        return $customer;
    }
}
