<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Page;

class PageDelete extends Controller
{
    public function __invoke(string $pageID, Request $request)
    {
        Page::modelFactory()->remove(ids: [$pageID]);

        return redirect()->back()->with(['success' => 'Page Deleted']);
    }

}
