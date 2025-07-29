<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDeviceId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deviceId = session('device_id');
        // dd($deviceId, 'dfdf');
        if (!$deviceId) {
            $deviceId = (string) Str::uuid();
            $updatedData = [
                'data' => $deviceId,
                'expires_at' => now()->addDays(7),
            ];
            session()->put('device_id', $deviceId);
        }
        return $next($request);
    }
}
