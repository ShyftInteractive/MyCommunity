<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use Dompdf\FrameReflower\Page;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Template\Template;
use App\Domain\Models\MCS\Workspace\Content;

class PageStore extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $page = Page::modelFactory()->create([
            "slug" => $request->input('slug'),
            "title" => $request->input('title'),
            "isHomepage" => $request->input('isHomepage'),
            "visibility" => $request->input('visibility'),
            "content" => Template::byWorkspace($request->get('workspace_id'))->byName($request->input('template'))->first()->content,
            "workspace_id" => $request->get('workspace_id'),
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
