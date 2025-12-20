<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Allow admin, editor, ip_manager, and viewer to access admin panel
     * But specific permissions are controlled by Gates in AppServiceProvider
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'กรุณาเข้าสู่ระบบเพื่อเข้าถึงหน้านี้');
        }

        $user = Auth::user();
        
        // Allow these roles to access admin panel
        // Specific permissions are controlled by Gates
        $allowedRoles = ['admin', 'editor', 'ip_manager', 'viewer'];
        
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงส่วนนี้');
        }

        return $next($request);
    }
}
