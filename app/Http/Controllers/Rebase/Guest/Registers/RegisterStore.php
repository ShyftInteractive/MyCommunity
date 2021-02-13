<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use App\Http\Controllers\Controller;
use App\Events\Rebase\StartCustomerSignup;
use App\Http\Requests\CustomerSignupRequest;

class RegisterStore extends Controller
{
    public function __invoke(CustomerSignupRequest $request)
    {
        event(new StartCustomerSignup($request->input()));

        return redirect()->route('register.complete');
    }

}
