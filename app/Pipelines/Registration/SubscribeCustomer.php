<?php

namespace App\Pipelines\Registration;

use App\Domain\Customers\Customer;
use App\Domain\Customers\CustomerService;
use Laravel\Cashier\Exceptions\PaymentFailure;
use App\Domain\Factories\Rebase\CustomerModelFactory;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\SubscriptionUpdateFailure;

class SubscribeCustomer
{
    public function __invoke($payload)
    {
        try {
            $customerService = app()->make(CustomerService::class);
            $customerService->chargeCustomer(
                customer: $payload->get('customer'),
                item: $payload->toArray(),
            );
        } catch (PaymentActionRequired | PaymentFailure $e) {
            dd($e->getMessage());

            return false;
        }

        return $payload;
    }
}
