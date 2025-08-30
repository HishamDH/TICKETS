<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $additionalData = $user->additional_data;

            if (!($additionalData['is_verified'] ?? false)) {
                session(['email' => $user->email]);
                return redirect()->route('otpConfermation.index');
            }
        }

        return $next($request);
    }
}
