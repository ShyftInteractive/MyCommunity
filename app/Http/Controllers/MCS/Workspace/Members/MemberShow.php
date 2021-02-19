<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Members;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Members\MemberService;
use App\Domain\Facades\Rebase\MemberRepository;
use App\Domain\Facades\Rebase\WorkspaceRepository;

class MemberShow extends Controller
{
    public function __construct(private MemberService $memberService) { }

    public function __invoke(string $memberID, Request $request)
    {

        dd ("hello there");

    }
}
