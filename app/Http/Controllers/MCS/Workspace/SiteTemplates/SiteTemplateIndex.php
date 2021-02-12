<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\Template\Template;
use App\Domain\Templates\TemplateService;

class SiteTemplateIndex extends Controller
{
    public function __construct(private TemplateService $templateService) { }

    public function __invoke(Request $request)
    {
        $templates = $this->templateService->findTemplates(
            workspaceID: $request->get('workspace_id'),
            search: $request->get('s'),
            count: (int) $request->get('count'),
        );

        return inertia(Action::getView($this), [
            'templates' => $templates->toArray(),
        ]);
    }
}
