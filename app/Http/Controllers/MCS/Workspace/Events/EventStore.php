<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Domain\Models\MCS\Workspace\Page;
use App\Domain\Models\MCS\Workspace\Event;
use App\Domain\Models\MCS\Workspace\Content;
use App\Domain\Models\MCS\Workspace\Template;

class EventStore extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate($this->rules($request->get('workspace_id')));

        $event = Event::modelFactory()->create([
            "title" => $request->input('title'),
            "visibility" => $request->input('visibility'),
            'description' => $request->input('description'),
            "start_at" => $request->get('start_at'),
            "end_at" => $request->get('end_at'),
            "workspace_id" => $request->get('workspace_id'),
            "member_id" => auth()->user()->id
        ]);

        return redirect()->route('event.index');
    }

    private function rules(string $workspaceID): array
    {
        return [
            'title' => ['string', 'required', 'max:100'],
            'start_at' => 'required|date',
            'end_date' => 'date|after:start_at',
            'visibility' => ['required'],
        ];
    }
}
