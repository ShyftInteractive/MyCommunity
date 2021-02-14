<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Auth;

use Inertia\Response;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Lookup\LookupService;
use App\Exceptions\SubdomainLookupException;
use App\Http\Controllers\Controller;

class Login extends Controller
{
    public function __construct(private LookupService $lookupService) { }

    public function __invoke(Request $request)
    {
        try {
            $this->lookupService->customerLoginExists(
                customerID: $request->get('customer_id'),
                subdomain: $request->get('to'),
            );
        } catch (SubdomainLookupException $e) {
            return redirect()->route('search.index')->with('message', $e->getMessage());
        }

        return inertia(Action::getView($this), [
            'customer_id' => $request->get('customer_id'),
            'to' => $request->get('to'),
        ]);
    }
}
