<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Components;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Template;

class ComponentShow extends Controller
{
    public function __invoke(string $templateID, string $componentID, Request $request)
    {
        $template = Template::byID($templateID)->first();

        $content = $template->content;
        $content[$request->input('row')][$request->input('column')]['component'] = Storage::disk('components')->get("{$componentID}.htm");
        $template->content = $content;

        $template->update();

        return redirect()->back();
    }
}
