<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VpnRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = env('ALLOWED_VPN_IP');
        $userIp = $request->ip();

        // Localhost/Internal is always allowed for development
        if ($userIp === '127.0.0.1' || $userIp === '::1' || strpos($userIp, '192.168.') === 0) {
            return $next($request);
        }

        // If no VPN IP is configured in Railway/ENV, allow access (emergency fallback)
        if (!$allowedIps) {
            return $next($request);
        }

        // Convert comma-separated string to array
        $allowedArray = array_map('trim', explode(',', $allowedIps));

        // Block if user IP is not in the allowed list
        if (!in_array($userIp, $allowedArray)) {
            abort(403, 'Access Denied: This platform is only accessible when connected to the Kadellabs Pritunl VPN.');
        }

        return $next($request);
    }
}
