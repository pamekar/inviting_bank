<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $response = $next($request);
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000;

        // Exclude internal routes to prevent infinite loops and noise
        if ($request->is('livewire/*') || $request->is('_debugbar/*')) {
            return $response;
        }

        try {
            $responseBody = null;
            $contentType = $response->headers->get('Content-Type');

            if (str_contains($contentType, 'application/json') || str_contains($contentType, 'text/')) {
                $content = $response->getContent();
                // Limit body size to prevent huge logs
                $responseBody = strlen($content) > 10000 ? json_decode(substr($content, 0, 10000)) : json_decode($content, true) ?? $content;
            } else {
                $responseBody = ['message' => 'Binary or non-text content omitted'];
            }

            \App\Models\RequestLog::create([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'request_body' => $request->all(),
                'response_body' => $responseBody,
                'status_code' => $response->status(),
                'ip_address' => $request->ip(),
                'duration_ms' => (int) $duration,
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to log request: ' . $e->getMessage());
        }

        return $response;
    }
}
