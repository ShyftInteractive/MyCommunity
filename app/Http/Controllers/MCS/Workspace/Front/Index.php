<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Front;

use Exception;
use Illuminate\Http\Request;
use App\Domain\Pages\PageService;
use App\Http\Controllers\Controller;
use App\Domain\Notifications\NotificationService;

class Index extends Controller
{
    public function __construct(
        private PageService $pageService,
        private NotificationService $notificationService
    ) {
    }

    public function __invoke(Request $request, string $slug = '')
    {
        try {
            $banner = $this->notificationService->getActiveBanner($request->get('workspace_id'));
            $pages = $this->pageService->getPublishedPages($request->get('workspace_id'));

            $content = $this->pageService->getActiveContent(
                slug: $slug,
                pages: $pages,
            );
        } catch (Exception $e) {
            return abort(404);
        }

        return view('front.front', [
            'pages' => $pages,
            'content' => $content,
            'banner' => $banner,
        ]);
    }

    private function getWorkspaceStoragePath($request)
    {
        return "customers.data.{$request->get('customer_id')}.{$request->get('workspace_id')}";
    }
}
