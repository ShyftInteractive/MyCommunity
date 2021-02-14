<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Guest\Registers;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterPayACH extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return inertia(Action::getView($this), [
            'sub' => $request->get('sub'),
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'plan' => $request->get('plan'),
            'pickedProduct' => $request->get('pickedProduct'),
        ]);
    }
}
