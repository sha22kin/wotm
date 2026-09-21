<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check session first, then cookie, default to 'bn' (Bangla)
        $locale = $request->session()->get('locale', $request->cookie('locale', 'bn'));

        if (!in_array($locale, ['en', 'bn'])) {
            $locale = 'bn';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
