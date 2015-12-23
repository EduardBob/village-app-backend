<?php
namespace Modules\Village\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $role
     *
     * @throws \Exception
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();
        if (!$user) {
            $user = JWTAuth::parseToken()->authenticate();
        }

        if (!$user || !$user->inRole($role)) {
            throw new \Exception('user has no role '.$role);
        }

        return $next($request);
    }
}