<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Admin\Customers;

use App\Actions\Action;
use App\Domain\Roles\Role;
use Illuminate\Http\Request;
use App\Enums\Rebase\MemberRoles;
use App\Domain\Customers\Customer;
use App\Http\Controllers\Controller;
use App\Domain\Facades\Rebase\RoleRepository;
use App\Domain\Facades\Rebase\MemberRepository;
use App\Domain\Facades\Rebase\CustomerRepository;
use App\Domain\Facades\Rebase\WorkspaceRepository;

class CustomerIndex extends Controller
{
    public function __invoke(string $customerID, Request $request)
    {
        $customer = Customer::withSubscriptions($request->get('customer_id'))->first();

        return inertia(Action::getView($this), [
            'customer' => $customer,
            'invoices' => $customer->mapInvoices()->toArray(),
            'owner' => Role::accountOwner()->first()->members->first()
        ]);
    }
}
