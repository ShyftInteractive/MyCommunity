<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use Inertia\Inertia;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Template\Template;

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

        $updateItems = $this->appendComponent($updateItems, $request->input('component'));

        Template::modelFactory()->update(
            whereCol: 'id',
            whereValue: $templateID,
            update: $updateItems
        );

        if (!is_null($request->input('component')['name'])) {
            return Inertia::location(route('site-template.edit', ['templateID' => $templateID]));
        }

        return redirect()->back()->with('success', "Template Saved");
    }

    private function appendComponent($items, $component)
    {
        if (is_null($component['name'])) {
            return $items;
        }
        $row = (int)$component['row'];
        $col = (int)$component['col'];
        $content = $items['content'];

        $content[$row]['cols'][$col]['component'] = Storage::disk('static')->get("components/{$component['name']}/{$component['name']}.htm");
        $items['content'] = $content;

        return $items;
    }
}
