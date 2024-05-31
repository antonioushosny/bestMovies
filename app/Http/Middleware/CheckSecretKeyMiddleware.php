<?php

namespace App\Http\Middleware;

use App\Http\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Support\Facades\Cache;

class CheckSecretKeyMiddleware
{
    use JsonResponseTrait;

    public function handle($request, Closure $next)
    {
        $secretKey = $request->header('Secret-Key');
        $validSecretKey = env('SECRET_KEY');
        if ($secretKey !== $validSecretKey) {
            $message = 'Invalid Secret Key';
            return $this->jsonResponse(401, $message, [$message], null);
        }

        return $next($request);
    }
}
