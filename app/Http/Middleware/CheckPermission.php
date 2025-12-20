<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * Check if user has specific permission using Gates
     *
     * @param  string  $permission - The gate name to check
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Gate::allows($permission)) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงส่วนนี้');
        }

        return $next($request);
    }
}
