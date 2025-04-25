<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $lang = app()->getLocale();  // ar | en
        $titleCol = "title_{$lang} as title";
        $descCol = "description_{$lang} as description";
        
        // Get all services with pagination
        $services = Service::select([
                        'id', 'slug', 'cover_image',
                        $titleCol, $descCol, 'price', 'currency',
                        "unit_{$lang} as unit"
                    ])
                    ->withCount('images')
                    ->latest('id')
                    ->paginate(6);

                    
        return view('frontend.services', compact('services', ));
    }

    /**
     * Display the specified service.
     */
    public function show($slug)
    {
        $lang = app()->getLocale();
        $titleCol = "title_{$lang} as title";
        $descCol = "description_{$lang} as description";
        $metaTitleCol = "meta_title_{$lang} as meta_title";
        $metaDescCol = "meta_description_{$lang} as meta_description";
        $metaKeywordsCol = "meta_keywords_{$lang} as meta_keywords";
        $unitCol = "unit_{$lang} as unit";
        $altTextCol = "alt_text_{$lang} as alt_text";
        
        $service = Service::select([
                        'id', 'slug', 'cover_image',
                        $titleCol, $descCol, 'price', 'currency', $unitCol,
                        $metaTitleCol, $metaDescCol, $metaKeywordsCol
                    ])
                    ->whereSlug($slug)
                    ->with([
                        'images:id,service_id,image_path,' . $altTextCol . ',is_main'
                    ])
                    ->firstOrFail();
                    
        // Get previous and next services
        $previous = Service::select(['id', 'slug', $titleCol])
                        ->where('id', '<', $service->id)
                        ->orderBy('id', 'desc')
                        ->first();
                        
        $next = Service::select(['id', 'slug', $titleCol])
                        ->where('id', '>', $service->id)
                        ->orderBy('id', 'asc')
                        ->first();
                    
        // Get related services (except current one)
        $relatedServices = Service::select([
                            'id', 'slug', 'cover_image',
                            $titleCol, $descCol, 'price', 'currency', $unitCol
                        ])
                        ->where('id', '!=', $service->id)
                        ->inRandomOrder()
                        ->limit(3)
                        ->get();
        
        
        return view('frontend.service-detail', compact('service', 'relatedServices',  'previous', 'next'));
    }
    

}