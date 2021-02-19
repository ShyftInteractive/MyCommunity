<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;

class MemberUploadDelete extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, Request $request)
    {
        $this->memberService->removeAvatar(
            workspaceID: $request->get('workspace_id'),
            memberID: $memberID,
        );

        return redirect()->back();
    }
}
