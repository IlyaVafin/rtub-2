<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token  = $request->bearerToken();
        if(!$token) return abort(403);
        $user = User::where('token', $token)->first();
        if(!$user) return abort(403);
        auth()->login($user);
        return $next($request);
    }
}
