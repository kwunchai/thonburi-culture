<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIpPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // ตรวจสอบว่าผู้ใช้มีสิทธิ์จัดการ IP หรือไม่
        if (!$user || !in_array($user->role, ['admin', 'ip_manager'])) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'ไม่มีสิทธิ์เข้าถึงข้อมูลทรัพย์สินทางปัญญา'], 403);
            }

            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลทรัพย์สินทางปัญญา');
        }

        return $next($request);
    }
}