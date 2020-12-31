<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Posts;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Template;

class PostCreate extends Controller
{
    public function __invoke(Request $request)
    {
        $templates = Template::activated()->select(['name'])->get()->map(function($item) {
            return $item->name;
        })->toArray();

        return inertia(Action::getView($this), [
            'templates' => $templates,
        ]);
    }
}
