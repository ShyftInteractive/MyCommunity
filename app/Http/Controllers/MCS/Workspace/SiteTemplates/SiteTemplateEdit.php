<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use Inertia\Inertia;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Template;

class SiteTemplateEdit extends Controller
{
    public function __invoke(string $templateID, Request $request)
    {
        return inertia(Action::getView($this), [
            'template' => Template::byID($templateID)->first(),
        ]);
    }
}
