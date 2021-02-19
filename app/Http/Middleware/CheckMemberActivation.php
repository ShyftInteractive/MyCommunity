<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\BaseMiddleware;

class CheckMemberActivation extends BaseMiddleware
{
    protected array $except = [
        'storage',
        'horizon',
        'register',
        '*/hold',
        'logout',
        '_debugbar',
        'stripe',
        'search',
    ];


    public function handle(Request $request, Closure $next)
    {

        if ($this->shouldIgnore($request->path())) {
            return $next($request);
        }

        if (Auth::user() && !Auth::user()->activated) {
            return redirect()->route('hell', ['customerID' => $request->get('customer_id')]);
        }

        return $next($request);
    }
}
