<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\PickPlanPaymentRequest;

class RegisterPickPlanProcess extends Controller
{
    public function __invoke(PickPlanPaymentRequest $request)
    {
        $planID = $request->input('plan');

        $pickedProduct = collect(config('pricing.product.test'))->filter(function($item) use ($planID) {
            return $item['id'] === $planID;
        });

        $data = [
            'sub' => $request->input('sub'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'plan' => $planID,
            'pickedProduct' => $pickedProduct->first(),
        ];

        if ($request->input('ach')) {
            return redirect()->route('register.pay.ach', $data);
        }

        // This generats a 409 Conflict on purpose see InertiaJS
        // docs for more info: https://inertiajs.com
        return Inertia::location(route('register.pay.cc', $data));
    }
}
