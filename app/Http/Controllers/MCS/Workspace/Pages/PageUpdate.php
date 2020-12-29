<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Page;

class PageUpdate extends Controller
{
    public function __invoke(string $pageID, Request $request)
    {
            $updateItems = collect($request->only([
                "page.id",
                "page.workspace_id",
                "page.slug",
                "page.path",
                "page.title",
                "page.description",
                "page.content",
                "page.visibility",
                "page.published_at",
            ]))->get('page');

        Page::modelFactory()->update(
            whereCol: 'id',
            whereValue: $pageID,
            update: $updateItems);


        return redirect()->back()->withSuccess('Saved');
    }
}
