<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustedHosts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $trustedHosts = [
            // Railway infrastructure hosts
            'healthcheck.railway.app',
            'railway.app',
            '*.railway.app',
            
            // Production domain (update when you have custom domain)
            parse_url(config('app.url'), PHP_URL_HOST),
            
            // Local development
            'localhost',
            '127.0.0.1',
            '0.0.0.0',
            
            // Railway service domains
            '*.up.railway.app',
        ];

        // Get the current host
        $currentHost = $request->getHost();
        
        // Check if current host is trusted
        $isTrusted = false;
        
        foreach ($trustedHosts as $trustedHost) {
            if ($this->hostMatches($currentHost, $trustedHost)) {
                $isTrusted = true;
                break;
            }
        }
        
        // For Railway healthcheck specifically, always allow
        if ($this->isRailwayHealthcheck($request)) {
            $isTrusted = true;
        }
        
        // If not trusted and not in debug mode, reject
        if (!$isTrusted && !config('app.debug')) {
            return response('Forbidden - Host not allowed', 403);
        }
        
        return $next($request);
    }
    
    /**
     * Check if host matches pattern (supports wildcards)
     */
    private function hostMatches(string $host, string $pattern): bool
    {
        // Direct match
        if ($host === $pattern) {
            return true;
        }
        
        // Wildcard match
        if (str_contains($pattern, '*')) {
            $regex = str_replace(['*', '.'], ['.*', '\.'], $pattern);
            return preg_match('/^' . $regex . '$/i', $host);
        }
        
        return false;
    }
    
    /**
     * Check if this is a Railway healthcheck request
     */
    private function isRailwayHealthcheck(Request $request): bool
    {
        // Check User-Agent for Railway healthcheck
        $userAgent = $request->userAgent();
        if ($userAgent && str_contains(strtolower($userAgent), 'railway')) {
            return true;
        }
        
        // Check for Railway healthcheck headers
        $railwayHeaders = [
            'X-Railway-Healthcheck',
            'X-Forwarded-For-Railway',
            'X-Railway-Request-Id'
        ];
        
        foreach ($railwayHeaders as $header) {
            if ($request->hasHeader($header)) {
                return true;
            }
        }
        
        // Check host patterns for Railway
        $host = $request->getHost();
        $railwayPatterns = [
            'healthcheck.railway.app',
            'railway.app',
            '*.railway.app',
            '*.up.railway.app'
        ];
        
        foreach ($railwayPatterns as $pattern) {
            if ($this->hostMatches($host, $pattern)) {
                return true;
            }
        }
        
        return false;
    }
}