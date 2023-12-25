<?php

namespace App\Http\Middleware;

use Closure;
use GSVnet\Core\Exceptions\UserAccountNotApprovedException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->approved)
            throw new UserAccountNotApprovedException;

        return $next($request);
    }
}
