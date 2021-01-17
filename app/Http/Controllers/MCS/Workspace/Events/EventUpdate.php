<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventUpdate extends Controller
{
    public function __invoke(string $eventID, Request $request)
    {
        $updateItems = $request->only([
            'title', 'start_at', 'end_at', 'description', 'visiblity',
        ]);

        $updateItems['start_at'] = $updateItems['start_at'] == null ? null : Carbon::parse($updateItems['start_at']);
        $updateItems['end_at'] = $updateItems['end_at'] == null ? null : Carbon::parse($updateItems['end_at']);


        $start = $updateItems['start_at'];
        $end =  $updateItems['end_at'];

        dd($start->diffInMinutes($end, false));

        Event::modelFactory()->update(
            whereCol: 'id',
            whereValue: $eventID,
            update: $updateItems
        );


        return redirect()->back()->withSuccess('Saved');
    }

    private function rules(array $x)
    {
        return [
            'start_date' => ['required'],
            'end_date' => ['sometimes', 'after:start_date']
        ];
    }
}
