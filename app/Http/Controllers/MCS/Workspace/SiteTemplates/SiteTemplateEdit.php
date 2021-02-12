<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\SiteTemplates;

use Inertia\Inertia;
use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Template\Template;
use App\Domain\Templates\TemplateService;

class SiteTemplateEdit extends Controller
{
    public function __construct(private TemplateService $templateService) { }

    public function __invoke(string $templateID, Request $request)
    {
        $template = $this->templateService->getWorkspaceItem(
            workspaceID: $request->get('workspace_id'),
            id: $templateID,
        );

        return inertia(Action::getView($this), [
            'template' => $template->toArray(),
            'components' => $this->mapComponents('/static/'),
        ]);
    }

    private function mapComponents(string $componentPath)
    {
        return collect(Storage::disk('static')->allDirectories('components'))->map(function ($component) use ($componentPath) {
            $name = str_replace(search: 'components/', replace: '', subject: $component);
            return [
                'image' => "{$componentPath}{$component}/{$name}.png",
                'name' => $name,
                'code' => "{$componentPath}{$component}/{$name}.htm"
            ];
        });
    }
}
