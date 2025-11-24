<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        // Tidak login → redirect
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Jika method hasPermission tidak ditemukan
        if (!method_exists($user, 'hasPermission')) {
            abort(500, 'User model missing hasPermission method');
        }

        // Jika user tidak punya permission
        if (!$user->hasPermission($permission)) {
            abort(403, 'Permission denied');
        }

        return $next($request);
    }
}
