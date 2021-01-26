<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Post;

class GroupUpdate extends Controller
{
    public function __invoke(string $postID, Request $request)
    {
    }
}
