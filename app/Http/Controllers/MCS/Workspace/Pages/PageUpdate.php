<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\Pages\PageService;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Page;

class PageUpdate extends Controller
{
    public function __construct(private PageService $pageService)
    {
    }
    public function __invoke(string $pageID, Request $request)
    {
        $this->pageService->updatePage(
            pageID: $pageID,
            updates: $request->only(
                "id",
                "workspace_id",
                "slug",
                "path",
                "title",
                "description",
                "content",
                "published",
                "is_homepage",
                "visibility",
                "published_at",
            )
        );

        return redirect()->back()->withSuccess('Page has been updated');
    }
}
