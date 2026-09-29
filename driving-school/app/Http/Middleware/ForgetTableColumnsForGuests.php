<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForgetTableColumnsForGuests
{
    /**
     * Drop the viewer's table column choices once there is no logged-in user
     * (after logout or when the session expired), so they don't outlive the session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->hasCookie('table_columns') && ! Auth::check()) {
            $response->headers->setCookie(cookie()->forget('table_columns'));
        }

        return $response;
    }
}
