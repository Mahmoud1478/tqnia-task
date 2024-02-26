<?php

namespace App\Http\Middleware;

use App\Services\Api\Response\HasApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserMiddleware
{
    use HasApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!is_null(auth()->user()->verification_code)){
            return $this->failedMessageResponse('unverified user');
        }
        return $next($request);
    }
}
