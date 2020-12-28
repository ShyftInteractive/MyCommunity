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
        $page = Page::with('content')->byID($pageID)->first();

        return redirect()->back();
    }
}
