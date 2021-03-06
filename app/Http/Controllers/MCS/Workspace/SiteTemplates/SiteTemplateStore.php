<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use SebastianBergmann\Template\Template;
use App\Domain\Templates\TemplateService;

class SiteTemplateStore extends Controller
{
    public function __construct(private TemplateService $templateService) { }

    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $template = $this->templateService->createTemplate(
            inputs: $request->input(),
            workspaceID: $request->get('workspace_id'),
        );

        return redirect()->route('site-template.edit', [
            'templateID' => $template->id,
        ]);
    }

    private function rules(string $workspaceID): array
    {
    return [
            'name' => ['string', 'required', 'max:100', Rule::unique('workspace.templates')->where('workspace_id', $workspaceID)],
        ];
    }
}
