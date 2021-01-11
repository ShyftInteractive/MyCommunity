<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Media;

use App\Actions\Action;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\MCS\MediaTypes;
use Illuminate\Validation\Rule;
use App\Enums\Rebase\MemberRoles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Domain\Models\MCS\Workspace\Media;

class MediaUpload extends Controller
{
    public function __invoke(Request $request)
    {
        $path = "{$request->get('customer_id')}/{$request->get('workspace_id')}";
        $extension = $request->file('file')->getClientOriginalExtension();

        $filename = Str::of($request->file('file')->getClientOriginalName())->beforeLast('.');
        $name = Str::slug(Str::lower($filename));

        $isValid = Validator::make([
            'name' => "{$name}.{$extension}",
            'file' => $request->file('file'),
        ], $this->rules($request->get('workspace_id')));

        if ($isValid->fails()) {
            $e = ['name' => $request->file('file')->getClientOriginalName(), 'm' => $isValid->errors()->first()];
            abort(500, json_encode($e));
        }

        Storage::disk('spaces')->putFileAs($path, $request->file('file'), "{$name}.{$extension}", 'public');

        $path = "{$path}/{$name}.{$extension}";

        $mediaItem = Media::create([
            'name' => "{$name}.{$extension}",
            'type' => $this->setType($extension),
            'path' => $path,
            'url' => Storage::disk('spaces')->url($path),
            'visiblity' => MemberRoles::MEMBER(),
            'workspace_id' => $request->get('workspace_id'),
        ]);

        return $mediaItem->toJson();
    }

    private function rules(string $workspaceID): array
    {
        return [
            'name' => ['bail', 'required', 'max:255', Rule::unique('workspace.media')->where('workspace_id', $workspaceID)],
            'file' => 'bail|required|file|mimes:jpeg,jpg,png,gif,svg,webp,csv,txt,xlx,xls,pdf,doc,docx,pages,numbers,mp3,mp4,mov'
        ];
    }

    private function setType(string $extension)
    {
        return  match ($extension) {
                'pdf' => MediaTypes::DOCUMENT(),
                'doc' => MediaTypes::DOCUMENT(),
                'docx' => MediaTypes::DOCUMENT(),
                'xls' => MediaTypes::DOCUMENT(),
                'xlsx' => MediaTypes::DOCUMENT(),
                'xlx' => MediaTypes::DOCUMENT(),
                'txt' => MediaTypes::DOCUMENT(),
                'pages' => MediaTypes::DOCUMENT(),
                'numbers' => MediaTypes::DOCUMENT(),
                'cvs' => MediaTypes::DOCUMENT(),
                'png' => MediaTypes::IMAGE(),
                'jpg' => MediaTypes::IMAGE(),
                'svg' => MediaTypes::IMAGE(),
                'jpeg' => MediaTypes::IMAGE(),
                'gif' => MediaTypes::IMAGE(),
                'webp' => MediaTypes::IMAGE(),
                'mp3' => MediaTypes::AUDIO(),
                'mp4' => MediaTypes::VIDEO(),
                'mov' => MediaTypes::VIDEO(),
                default => MediaTypes::OTHER(),
        };
    }
}
