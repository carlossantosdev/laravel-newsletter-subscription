<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('x-token');

        $user = User::whereToken($token)->first();

        if (is_null($user)) {
            return response()->json(data: ['message' => 'Invalid token.'], status: 401);
        }

        Auth::loginUsingId($user->id);

        return $next($request);
    }
}
