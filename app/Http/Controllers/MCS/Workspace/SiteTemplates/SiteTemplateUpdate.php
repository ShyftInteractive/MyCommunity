<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Template;

class SiteTemplateUpdate extends Controller
{
    public function __invoke(string $templateID, Request $request)
    {
        $updateItems = collect($request->only([
            "template.id",
            "template.workspace_id",
            "template.name",
            "template.content",
            "template.active",
        ]))->get('template');

        Template::modelFactory()->update(
            whereCol: 'id',
            whereValue: $templateID,
            update: $updateItems
        );

        return redirect()->back()->withSuccess('Saved');
    }
}
