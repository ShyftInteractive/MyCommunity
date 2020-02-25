<?php
namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Actions\GetView;
use Illuminate\Http\Request;
use App\Domain\Resources\UserResource;

class IndexDashboardController
{
    public function __invoke(Request $request)
    {


        if ($request->getMethod() === 'GET') {
            return Inertia::render(GetView::execute($this), [])->withViewData('stripe', false);
        }


        $x = [
            [
                'id' => 22,
                'name' => 'Joe',
                'email' => 'joe@cianflone.co',
            ],[
                'id' => 23,
                'name' => 'Joe',
                'email' => 'joe@cianflone.co',
            ]
        ];

        $resource = new UserResource($x);

        return Inertia::render(GetView::execute($this), [
            'user' => $resource->get()
        ])->withViewData('stripe', false);
    }
}
