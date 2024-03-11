<?php

namespace App\Http\Middleware;

use App\ApiUser;
use App\Models\Api;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Api-Key');

        // sanctum icin authentication
        if (is_null($apiKey) && !is_null($request->header('Authorization'))) {
            if (auth('sanctum')->check()) {
                app(ApiUser::class)->setUser(auth('sanctum')->user());

                return $next($request);
            }

            return response()->json([
                'message' => 'unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $api = Api::query()->where('token', '=', $apiKey)->first();

        if (! $api) {
            return response()->json([
                'message' => 'unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        app(ApiUser::class)->setUser(User::query()->find($api->user_id));

        return $next($request);
    }
}
