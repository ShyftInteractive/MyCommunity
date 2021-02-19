<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;

class MemberSelected extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $action, Request $request)
    {

        $this->memberService->updateSelectedMembers(
            action: $action,
            requests: $request->input(),
        );

        return redirect()->back()->with(['success' => 'Updated!']);
    }
}
