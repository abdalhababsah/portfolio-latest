<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = SiteSetting::all();
        
        return view('admin.site-settings.index', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key_name' => 'required|string|max:100|unique:site_settings',
            'value_en' => 'nullable|string',
            'value_ar' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'about_me_en' => 'nullable|string',
            'about_me_ar' => 'nullable|string',
            'email' => 'nullable|email',
            'hero_heading_en' => 'nullable|string',
            'hero_heading_ar' => 'nullable|string',
            'hero_tagline_en' => 'nullable|string',
            'hero_tagline_ar' => 'nullable|string',
            'site_title_en' => 'nullable|string',
            'site_title_ar' => 'nullable|string',
            'cv_url' => 'nullable|string',
        ]);

        // Handle file upload if present
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('site-settings', 'public');
            $validated['value_en'] = $path;
        }

        // Create setting based on the type
        if (Str::startsWith($request->key_name, 'profile_image')) {
            // Image already handled above
        } elseif (Str::startsWith($request->key_name, 'about_me')) {
            $validated['value_en'] = $request->about_me_en;
            $validated['value_ar'] = $request->about_me_ar;
        } elseif (Str::startsWith($request->key_name, 'email')) {
            $validated['value_en'] = $request->email;
        } elseif (Str::startsWith($request->key_name, 'hero_heading')) {
            $validated['value_en'] = $request->hero_heading_en;
            $validated['value_ar'] = $request->hero_heading_ar;
        } elseif (Str::startsWith($request->key_name, 'hero_tagline')) {
            $validated['value_en'] = $request->hero_tagline_en;
            $validated['value_ar'] = $request->hero_tagline_ar;
        } elseif (Str::startsWith($request->key_name, 'site_title')) {
            $validated['value_en'] = $request->site_title_en;
            $validated['value_ar'] = $request->site_title_ar;
        } elseif (Str::startsWith($request->key_name, 'cv_url')) {
            $validated['value_en'] = $request->cv_url;
        }

        SiteSetting::create($validated);

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Setting created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSetting $siteSetting)
    {
        return response()->json($siteSetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        $validated = $request->validate([
            'key_name' => 'required|string|max:100|unique:site_settings,key_name,'.$siteSetting->id,
            'value_en' => 'nullable|string',
            'value_ar' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'about_me_en' => 'nullable|string',
            'about_me_ar' => 'nullable|string',
            'email' => 'nullable|email',
            'hero_heading_en' => 'nullable|string',
            'hero_heading_ar' => 'nullable|string',
            'hero_tagline_en' => 'nullable|string',
            'hero_tagline_ar' => 'nullable|string',
            'site_title_en' => 'nullable|string',
            'site_title_ar' => 'nullable|string',
            'cv_url' => 'nullable|string',
        ]);

        // Handle file upload if present
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if (Str::startsWith($siteSetting->key_name, 'profile_image') && !empty($siteSetting->value_en)) {
                Storage::disk('public')->delete($siteSetting->value_en);
            }
            
            $path = $request->file('profile_image')->store('site-settings', 'public');
            $validated['value_en'] = $path;
        }

        // Update setting based on the type
        if (Str::startsWith($request->key_name, 'profile_image')) {
            // Image already handled above
            if (!$request->hasFile('profile_image')) {
                $validated['value_en'] = $siteSetting->value_en;
            }
        } elseif (Str::startsWith($request->key_name, 'about_me')) {
            $validated['value_en'] = $request->about_me_en;
            $validated['value_ar'] = $request->about_me_ar;
        } elseif (Str::startsWith($request->key_name, 'email')) {
            $validated['value_en'] = $request->email;
        } elseif (Str::startsWith($request->key_name, 'hero_heading')) {
            $validated['value_en'] = $request->hero_heading_en;
            $validated['value_ar'] = $request->hero_heading_ar;
        } elseif (Str::startsWith($request->key_name, 'hero_tagline')) {
            $validated['value_en'] = $request->hero_tagline_en;
            $validated['value_ar'] = $request->hero_tagline_ar;
        } elseif (Str::startsWith($request->key_name, 'site_title')) {
            $validated['value_en'] = $request->site_title_en;
            $validated['value_ar'] = $request->site_title_ar;
        } elseif (Str::startsWith($request->key_name, 'cv_url')) {
            $validated['value_en'] = $request->cv_url;
            $validated['value_ar'] = $request->cv_url;
        }

        $siteSetting->update($validated);

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSetting $siteSetting)
    {
        // Delete file if it's an image
        if (Str::startsWith($siteSetting->key_name, 'profile_image') && !empty($siteSetting->value_en)) {
            Storage::disk('public')->delete($siteSetting->value_en);
        }
        
        $siteSetting->delete();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Setting deleted successfully');
    }
}