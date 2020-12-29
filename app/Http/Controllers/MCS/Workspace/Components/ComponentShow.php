<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Components;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Page;

class ComponentShow extends Controller
{
    public function __invoke(string $pageID, string $componentID, Request $request)
    {
        $page = Page::byID($pageID)->first();

        $content = $page->content;
        $content[$request->input('row')][$request->input('column')]['component'] = Storage::disk('components')->get("{$componentID}.htm");
        $page->content = $content;

        $page->update();

        return redirect()->back();
    }
}
