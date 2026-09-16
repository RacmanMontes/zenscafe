<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if ($request->user() === null) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role?->value;

        if ($userRole === null || ! in_array($userRole, $roles)) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized. You do not have the required role to access this resource.');
        }

        return $next($request);
    }
}
