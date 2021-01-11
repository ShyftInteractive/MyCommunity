<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Components;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Template;

class ComponentInsert extends Controller
{

    public function __invoke(string $templateID, string $componentID, Request $request)
    {
        $content = $request->input('content');
        $row = (int) $request->input('row');
        $col = (int) $request->input('col');
        $content[$row][$col]['component'] = Storage::disk('components')->get("{$componentID}.htm");

        Template::modelFactory()->update(
            whereCol: 'id',
            whereValue: $templateID,
            update: [
                'content' => $content
            ],
        );

        return redirect()->route('site-template.edit', [
            'templateID' => $templateID,
        ]);
    }
}
