<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogImportantRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->isImportantRequest($request)) {
            Log::info('Important request accessed', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $request->user()?->id,
                'user_email' => $request->user()?->email,
                'status_code' => $response->getStatusCode(),
                'time' => now()->toDateTimeString(),
            ]);
        }

        return $response;
    }

    private function isImportantRequest(Request $request): bool
    {
        return $request->is('login')
            || $request->is('logout')
            || $request->is('admin/*')
            || $request->is('api/*')
            || in_array($request->method(), [
                'POST',
                'PUT',
                'PATCH',
                'DELETE',
            ], true);
    }
}