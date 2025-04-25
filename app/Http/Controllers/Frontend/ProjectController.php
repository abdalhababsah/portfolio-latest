<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $lang = app()->getLocale();                    // ar  |  en
        $titleCol = "title_{$lang}   as title";
        $shortCol = "short_description_{$lang} as short_description";
        $nameCol = "name_{$lang}    as name";      // used for category & tech

        $projects = Project::select([
            'id',
            'slug',
            'cover_image',
            $titleCol,
            $shortCol,
            'category_id'
        ])
            ->with([
                // eager-load category with the right name column only
                'category:id,' . $nameCol,
                // eager-load a single main image (optional)
                'images:id,project_id,image_path,is_main',
            ])
            ->latest('id')
            ->paginate(9);

        return view('frontend.projects', compact('projects'));
    }

    public function show(string $slug)
    {
        $lang = app()->getLocale();
        $titleCol = "title_{$lang}   as title";
        $fullCol = "full_description_{$lang} as full_description";
        $roleCol = "role_{$lang}    as role";
        $durationCol = "duration_{$lang} as duration";
        $nameCol = "name_{$lang}    as name";
        $captionCol = "caption_{$lang} as caption";
        $thumbAlt = "thumbnail_alt_{$lang} as thumbnail_alt";

        $project = Project::select([
            'id',
            'slug',
            'cover_image',
            'github_url',
            'demo_url',
            $titleCol,
            $fullCol,
            $roleCol,
            $durationCol,
            'category_id'
        ])
            ->whereSlug($slug)
            ->with([
                // Category
                'category:id,' . $nameCol,
                // Technologies
                'technologies:id,' . $nameCol,
                // Tags
                'tags:id,' . $nameCol,
                // Gallery images
                'images:id,project_id,image_path,alt_text_' . $lang . ' as alt_text,is_main',
                // Videos
                'videos:id,project_id,video_url,' . $captionCol . ',thumbnail_path,' . $thumbAlt,
            ])
            ->firstOrFail();

        // Prev / Next (same column list so Blade props exist)
        $baseSelect = ['id', 'slug', 'cover_image', $titleCol];
        $previous = Project::select($baseSelect)
            ->where('id', '<', $project->id)
            ->orderByDesc('id')
            ->first();

        $next = Project::select($baseSelect)
            ->where('id', '>', $project->id)
            ->orderBy('id')
            ->first();

        return view('frontend.project-detail', compact('project', 'previous', 'next'));
    }
}