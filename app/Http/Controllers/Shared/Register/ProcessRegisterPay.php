<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shared\Register;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Domain\Repositories\Facades\AccountRepository;
use App\Http\Controllers\Controller as BaseController;

class ProcessRegisterPay extends BaseController
{
    /**
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'plan' => ['required'],
        ]);

        $account = AccountRepository::create([
            'id' => Str::uuid(),
            'name' => session('account.name'),
            'address_line1' => session('account.address_line1'),
            'address_line2' => session('account.address_line2'),
            'address_line3' => session('account.address_line3'),
            'city' => session('account.city'),
            'state' => session('account.state'),
            'is_business' => (bool) session('account.is_business'),
            'postal_code' => session('account.postal_code'),
        ]);

        /*
         * 1. Create a new Account
         * 2. create a new subscription for the Account
         * 3. Spin up the new site for them
         * 4. Return them to a page that makes sense
         */

        // @phpstan-ignore-next-line
        $account->newSubscription(config('pricing.plan.test'), $request->input('plan'))->create($request->input('payment_method'));

        return 'yay';
    }
}
