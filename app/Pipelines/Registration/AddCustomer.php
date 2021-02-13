<?php

namespace App\Pipelines\Registration;

use App\Domain\Customers\Customer;
use App\Domain\Customers\CustomerService;
use Carbon\Carbon;

class AddCustomer
{
    public function __invoke($payload)
    {
        $customerService = app()->make(CustomerService::class);
        $customer = $customerService->createCustomer(item: $payload->toArray());

        $payload->put('customer', $customer);

        return $payload;
    }
}
