<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Page;
use App\Domain\Models\MCS\Workspace\Content;

class PageStore extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $page = Page::modelFactory()->create($request->input());
        $pageContent = Content::modelFactory()->create([
            'page_id' => $page->id,
            'template_name' => $request->input('template'),
            'content' => Storage::disk('customer')->get('templates/homepage.htm'),
        ]);

        return redirect()->route('page.edit', [
            'pageID' => $page->id,
        ]);
    }

    private function rules(string $workspaceID): array
    {
    return [
            'title' => ['string', 'required', 'max:100'],
            'slug' => ['string', 'required', 'max:100', Rule::unique('workspace.pages')->where('workspace_id', $workspaceID)],
            'visibility' => ['required'],
        ];
    }
}
