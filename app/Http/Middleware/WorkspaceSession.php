<?php

namespace App\Http\Middleware;

use Closure;

class WorkspaceSession
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next): void
    {
        // if (!$request->session()->has('workspace_id')) {
        //     $request->session()->put('workspace_id', $workspaceID);

        //     return $next($request);
        // }

        // if ($request->session()->get('workspace_id') !== app('workspace')->id) {
        //     abort(401);
        // }
    }
}
