<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $user = Auth::user();

        if (
            Auth::check() &&
            $user &&
            $user->role === 'admin'
        ) {
            return $next($request);
        }

        return redirect('/')
            ->with(
                'error',
                'Unauthorized access'
            );
    }
}
