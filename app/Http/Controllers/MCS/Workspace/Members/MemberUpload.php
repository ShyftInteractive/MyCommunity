<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;
use App\Http\Requests\AvatarRequest;

class MemberUpload extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, AvatarRequest $request)
    {
        $this->memberService->uploadMemberAvatar(
            customerID: $request->get('customer_id'),
            workspaceID: $request->get('workspace_id'),
            memberID: $memberID,
            request: $request,
        );

        return json_encode(["success" => true]);
    }
}
