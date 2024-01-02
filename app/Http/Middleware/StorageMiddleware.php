<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StorageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->route('path') ?? '';

        if ($path && Str::startsWith($path, 'private/')) {
            if (auth()->check()) {
                abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
