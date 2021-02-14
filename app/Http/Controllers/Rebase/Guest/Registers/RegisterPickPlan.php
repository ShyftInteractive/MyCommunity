<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterPickPlan extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia(Action::getView($this), [
            'sub' => $request->input('sub'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
        ]);
    }
}
