<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\Template\Template;

class SiteTemplateIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $templates = Template::byWorkspace($request->get('workspace_id'))->searchable(
            searchTerm: $request->get('s'),
            searchFields: ['name']
        )->paginate($request->get('count') ?? 10);

        return inertia(Action::getView($this), [
            'templates' => $templates->toArray(),
        ]);
    }
}
