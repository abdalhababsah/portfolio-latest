<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        /* -------- 1. Raw page_view row (optional) -------- */
        DB::table('page_views')->insert([
            'route_name'  => optional($request->route())->getName() ?: 'UNNAMED',
            'method'      => $request->method(),
            'url'         => $request->fullUrl(),
            'user_id'     => Auth::id(),
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'referer'     => $request->header('referer'),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        /* -------- 2. Aggregate counter -------- */
        $route = optional($request->route())->getName() ?: 'UNNAMED';
        $today = now()->toDateString();                        // YYYY-MM-DD

        DB::table('page_view_aggregates')
            ->upsert(
                ['route_name' => $route, 'view_date' => $today, 'hits' => 1],
                ['route_name', 'view_date'],
                ['hits' => DB::raw('hits + 1')]
            );

        return $response;
    }
}