<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Skill;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\SiteSetting;
use App\Models\SocialLink;
class HomeController extends Controller
{
// app/Http/Controllers/HomeController.php

public function index()
{
    $locale = app()->getLocale();                      // "en" or "ar"

    /* ---------- SINGLE-ROW SETTINGS ---------- */
    $settings = SiteSetting::query()
        ->select('key_name', "value_{$locale} AS value")
        ->pluck('value', 'key_name');                  // ['site_title' => 'العنوان', …]

    /* ---------- SERVICES ---------- */
    $services = Service::query()
        ->with('images')
        ->select([
            'id',
            'slug',
            "title_{$locale}       AS title",
            "description_{$locale} AS description",
            'price',
            'currency',
            "unit_{$locale}        AS unit",
            'cover_image'
        ])
        ->latest()
        ->take(6)
        ->get();

    /* ---------- EXPERIENCES ---------- */
    $experiences = Experience::query()
        ->select([
            'id',
            "company_{$locale}   AS company",
            "position_{$locale}  AS position",
            'start_date',
            'end_date',
            "description_{$locale} AS description"
        ])
        ->latest('start_date')
        ->get();

    /* ---------- EDUCATION ---------- */
    $education = Education::query()
        ->select([
            'id',
            "institution_{$locale} AS institution",
            "degree_{$locale}      AS degree",
            'start_date',
            'end_date',
            "description_{$locale} AS description"
        ])
        ->latest('start_date')
        ->get();

    /* ---------- PROJECTS ---------- */
    $projects = Project::query()
        ->with([
            // keep relations light by selecting only translated fields we need
            'technologies:id,name_'.$locale,
            'tags:id,name_'.$locale,
            'images' => fn ($q) => $q->where('is_main', true)
        ])
        ->select([
            'id',
            'slug',
            "title_{$locale}              AS title",
            "short_description_{$locale}  AS short_description",
            "full_description_{$locale}   AS full_description",
            "role_{$locale}               AS role",
            "duration_{$locale}           AS duration",
            'cover_image',
            'category_id',
            'github_url',
            'demo_url'
        ])
        ->latest()
        ->take(6)
        ->get();

    /* ---------- TESTIMONIALS ---------- */
    $testimonials = Testimonial::query()
        ->select([
            'id',
            'name',
            'role',
            'image',
            'rating',
            "message_{$locale} AS message",
            'date_given'
        ])
        ->latest('date_given')
        ->take(5)
        ->get();

    /* ---------- SKILLS ---------- */
    $skills = Skill::query()
        ->with('category:id,name_'.$locale)
        ->select([
            'id',
            "name_{$locale}        AS name",
            "description_{$locale} AS description",
            'level',
            'category_id',
            'icon'
        ])
        ->get();

    /* ---------- BLOGS ---------- */
    $blogs = Blog::query()
        ->select([
            'id',
            'slug',
            "title_{$locale}   AS title",
            "summary_{$locale} AS summary",
            'cover_image',
            'reading_time',
            'created_at'
        ])
        ->latest()
        ->take(3)
        ->get();

    /* ---------- CERTIFICATES ---------- */
    $certificates = Certificate::query()
        ->select([
            'id',
            "title_{$locale}       AS title",
            "description_{$locale} AS description",
            'file_path',
            'issued_by',
            'date_issued',
            'expiry_date'
        ])
        ->latest('date_issued')
        ->get();

    $socialLinks = SocialLink::all();
    // Debugging data to ensure everything is loaded correctly
    // dd($services, $experiences, $education, $projects, $testimonials, $skills, $blogs, $certificates, $settings, $socialLinks);
    return view('frontend.index', compact(
        'services', 'experiences', 'education', 'projects',
        'testimonials', 'skills', 'blogs', 'certificates',
        'settings', 'socialLinks'
    ));
}

    public function blog()
    {
        return view('frontend.blog');
    }

    public function blogDetail()
    {
        return view('frontend.blog-detail');
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function serviceDetail()
    {
        return view('frontend.service-detail');
    }

    public function portfolio()
    {
        return view('frontend.projects');
    }

    public function portfolioDetail()
    {
        return view('frontend.project-detail');
    }

}