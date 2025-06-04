<?php

declare(strict_types=1);

namespace Jean\Logger\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Jean\Logger\Logger as L;

class LogAccess
{
    public function handle(Request $request, Closure $next, $message = 'Access Log', $category = "access-log", $guards = 'web')
    {
        $guardsArray = explode('|', $guards);
        $user = null;

        foreach ($guardsArray as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                break;
            }
        }

        L::info(
            message: $message,
            userId: optional($user)->id,
            category: $category,
            context: [
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ],
            ip: true,
        );

        return $next($request);
    }
}
