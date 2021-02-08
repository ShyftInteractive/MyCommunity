<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use SebastianBergmann\Template\Template;

class SiteTemplateDelete extends Controller
{
    public function __invoke(string $templateID, Request $request)
    {
        Template::modelFactory()->remove(ids: [$templateID]);

        return redirect()->back()->with(['success' => 'Template Deleted']);
    }

}
