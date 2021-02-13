<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckSubdomainRequest;

class RegisterCheckSubdomain extends Controller
{
    public function __invoke(CheckSubdomainRequest $request): RedirectResponse
    {
        return redirect()->route('register.email', [
            'sub' => $request->input('sub'),
        ]);
    }
}
