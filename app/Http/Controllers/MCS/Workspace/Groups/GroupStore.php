<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Groups;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Post;

class GroupStore extends Controller
{
    public function __invoke(Request $request)
    {
    }
}
