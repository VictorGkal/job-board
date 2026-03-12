<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEmployer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'employer') {
            abort(403, 'Access denied. Employer accounts only.');
        }

        return $next($request);
    }
}
