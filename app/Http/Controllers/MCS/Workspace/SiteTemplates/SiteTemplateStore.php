<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Template;

class SiteTemplateStore extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $template = Template::modelFactory()->create([
            'name' => $request->input('name'),
            'workspace_id' => $request->get('workspace_id'),
            'content' => []
        ]);

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
