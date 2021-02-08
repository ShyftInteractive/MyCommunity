<?php declare(strict_types=1);

namespace App\Domain\Customers;

use App\Domain\Customers\Customer;
use App\Enums\Rebase\CustomerStatus;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\SubscriptionUpdateFailure;

class CustomerModelFactory extends ModelFactory
{

    public function subscribe(Customer $customer, array $subscription): void
    {
        $subscription = collect($subscription);

        try {
            $customer->newSubscription(config('pricing.plan.test'), $subscription->get('plan'))
                ->create(
                    $subscription->get('method'),
                    $subscription->get('options')
                );
        } catch (PaymentActionRequired | PaymentFailure $e) {
            throw new SubscriptionUpdateFailure('Unable to subscribe due to Payment Failure');
        }
    }

    public function markAsActive(): void
    {
        $this->builder->update(['status' => CustomerStatus::ACTIVE()]);
    }
}
