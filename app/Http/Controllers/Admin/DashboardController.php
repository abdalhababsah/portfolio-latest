<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\{
    PageView,           // raw log – for unique visitors
    Project,
    Service,
    Skill,
    Certificate,
    Contact
};

class DashboardController extends Controller
{
    public function index()
    {
        /* ───── Traffic counters (aggregates) ───────────────────────── */

        // totals straight from the aggregate table
        $totalViews = DB::table('page_view_aggregates')->sum('hits');

        $today      = Carbon::today()->toDateString();
        $todayViews = DB::table('page_view_aggregates')
                        ->where('view_date', $today)
                        ->sum('hits');

        // unique IPs from the raw page_views log
        $uniqueVisitors = PageView::distinct('ip')->count();


        /* ───── 30-day daily views (fill missing days with 0) ───────── */

        $from = Carbon::today()->subDays(29);

        $raw  = DB::table('page_view_aggregates')
                    ->where('view_date', '>=', $from->toDateString())
                    ->select('view_date', DB::raw('SUM(hits) AS hits'))
                    ->groupBy('view_date')
                    ->pluck('hits', 'view_date');   // key = YYYY-MM-DD

        $dates  = [];
        $counts = [];

        for ($i = 0; $i < 30; $i++) {
            $day = $from->copy()->addDays($i)->toDateString();     // YYYY-MM-DD
            $dates[]  = Carbon::parse($day)->format('d M');        // e.g. 26 Apr
            $counts[] = $raw[$day] ?? 0;
        }


        /* ───── Top-visited routes ─────────────────────────────────── */

        $topRoutes = DB::table('page_view_aggregates')
                        ->select('route_name', DB::raw('SUM(hits) AS hits'))
                        ->groupBy('route_name')
                        ->orderByDesc('hits')
                        ->limit(7)
                        ->get();


        /* ───── Content / inbox counters ───────────────────────────── */

        $projectsCount     = Project::count();
        $servicesCount     = Service::count();
        $skillsCount       = Skill::count();
        $certificatesCount = Certificate::count();
        $unreadContacts    = Contact::unread()->count();


        /* ───── Return to view ─────────────────────────────────────── */

        return view('admin.dashboard', compact(
            'totalViews',
            'todayViews',
            'uniqueVisitors',
            'dates',
            'counts',
            'topRoutes',
            'projectsCount',
            'servicesCount',
            'skillsCount',
            'certificatesCount',
            'unreadContacts'
        ));
    }
}