<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ import Auth facade

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) { // ✅ ใช้ Auth::check() แทน
            return redirect('login');
        }

        $user = Auth::user();
        
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'ไม่มีสิทธิ์เข้าถึง');
    }
}
