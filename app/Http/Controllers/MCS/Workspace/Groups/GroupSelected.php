<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use Illuminate\Http\Request;
use App\Domain\Groups\GroupService;
use App\Http\Controllers\Controller;

class GroupSelected extends Controller
{
    public function __construct(private GroupService $groupService) { }

    public function __invoke(Request $request)
    {
    }
}
