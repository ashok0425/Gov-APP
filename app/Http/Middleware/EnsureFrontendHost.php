<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFrontendHost
{
    /**
     * Keep the public mobile web app on its own host in production.
     *
     * The admin panel and the frontend share one codebase, so without this
     * the frontend answers on every domain pointed at the app. Only the host
     * in config('app.frontend_host') may reach it once APP_ENV=production;
     * anything else looks like the route does not exist.
     *
     * The one exception is "/". On an admin host that is the front door of
     * the panel, not a missing page, so it lands on the dashboard (or the
     * login screen, for a guest) instead of a 404.
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        $allowed = strtolower(trim((string) config('app.frontend_host')));

        if ($allowed !== '' && strtolower($request->getHost()) !== $allowed) {
            if ($request->path() === '/') {
                return redirect()->route(Auth::check() ? 'dashboard' : 'login');
            }

            abort(404);
        }

        return $next($request);
    }
}
