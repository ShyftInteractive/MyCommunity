<?php declare(strict_types=1);

namespace App\Http\Controllers\Rebase\Admin\Members;

use Exception;
use Inertia\Inertia;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Domain\Members\MemberService;
use App\Http\Requests\MemberVerifyRequest;

class MemberVerify extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(MemberVerifyRequest $request)
    {
        try {
            $this->memberService->verifyMember(
                items: $request->input()
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors('We cannot match your email address in our system');
        }

        $request->session()->flash('success', 'Password has been set you can log in now!');
        return Inertia::location(route('signin', ['customer_id' => $request->input('customerID')]));
    }
}
