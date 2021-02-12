<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCreate extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia(Action::getView($this));
    }
}
