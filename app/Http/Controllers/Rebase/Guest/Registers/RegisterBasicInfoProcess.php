<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationBasicInfo;

class RegisterBasicInfoProcess extends Controller
{
    public function __invoke(RegistrationBasicInfo $request): RedirectResponse
    {
        return redirect()->route('register.pick-plan', [
            'sub' => $request->input('sub'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    }
}
