<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadGlobalViewData
{
    public function handle($request, Closure $next)
    {
        /* ---------- 1.  Figure out current locale ---------- */
        $locale = app()->getLocale();           // "en" or "ar"

        /* ---------- 2.  Site-wide key/value settings ---------- */
        $settings = cache()->remember(
            "site_settings_{$locale}",
            now()->addMinutes(10),              // tweak as needed
            function () use ($locale) {
                return SiteSetting::query()
                         ->select('key_name', "value_{$locale} AS value",'profile_image',"about_me_{$locale} AS about_me",'email')
                         ->pluck('value', 'key_name');   
            }
        );

        /* ---------- 3.  Social links (rarely change) ---------- */
        $socialLinks = cache()->remember(
            'social_links',
            now()->addMinutes(30),              // tweak as needed
            fn () => SocialLink::all()
        );

        /* ---------- 4.  Make them available to all views ---------- */
        View::share(compact('settings', 'socialLinks'));

        return $next($request);
    }
}
