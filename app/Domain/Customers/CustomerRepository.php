<?php declare(strict_types=1);

namespace App\Domain\Customers;

use Illuminate\Support\Carbon;
use App\Domain\Base\BaseRepository;

class CustomerRepository extends BaseRepository
{

    public function __construct(Customer $model)
    {
        parent::__construct(model: $model);
    }

    public function resource(array $item)
    {
        return [
            'name' => $item['name'],
            'line1' => $item['line1'],
            'line2' => $item['line2'] ?? null,
            'line3' => $item['line3'] ?? null,
            'unit_number' => $item['unit_number'] ?? null,
            'city' => $item['city'],
            'state' => $item['state'],
            'postal_code' => $item['postal_code'],
            'agreed_to_terms' => $item['agreed_to_terms'],
            'agreed_to_privacy' => $item['agreed_to_privacy'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function subscribe(Customer $customer, string $method, string $plan, array $options)
    {
        $customer
            ->newSubscription(config('pricing.plan.test'), $plan)
            ->create($method, $options);
    }
}
