<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Models\MCS\Workspace\Event;

class EventSelected extends Controller
{
    public function __invoke(string $action, Request $request)
    {
        match ($action) {
            'delete' => Event::destroy($request->input('selected'))
        };

        return redirect()->back()->with(['success' => 'Updated!']);
    }
}
