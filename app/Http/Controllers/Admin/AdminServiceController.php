<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create-update');
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
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'unit_en' => 'nullable|string|max:50',
            'unit_ar' => 'nullable|string|max:50',
            'cover_image' => 'nullable|image|max:2048',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string|max:255',
            'meta_keywords_en' => 'nullable|string|max:255',
            'meta_keywords_ar' => 'nullable|string|max:255',
            'service_images' => 'nullable|array',
            'service_images.*' => 'image|max:2048',
            'alt_texts_en' => 'nullable|array',
            'alt_texts_en.*' => 'nullable|string|max:255',
            'alt_texts_ar' => 'nullable|array',
            'alt_texts_ar.*' => 'nullable|string|max:255',
            'is_main' => 'nullable|array',
            'is_main.*' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('services/covers', 'public');
            $validated['cover_image'] = $path;
        }

        // Create the service
        $service = Service::create($validated);

        // Handle service images
        if ($request->hasFile('service_images')) {
            foreach ($request->file('service_images') as $index => $image) {
                $path = $image->store('services/images', 'public');
                
                $isMain = isset($request->is_main[$index]) ? (bool) $request->is_main[$index] : false;
                
                $service->images()->create([
                    'image_path' => $path,
                    'alt_text_en' => $request->alt_texts_en[$index] ?? null,
                    'alt_text_ar' => $request->alt_texts_ar[$index] ?? null,
                    'is_main' => $isMain,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('admin.services.create-update', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.services.create-update', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
/**
 * Update a service and its gallery images.
 */
public function update(Request $request, Service $service)
{
    /* ───── 1. Validate ──────────────────────────────────────────── */
    $validated = $request->validate([
        'title_en'   => 'required|string|max:255',
        'title_ar'   => 'required|string|max:255',
        'slug'       => 'nullable|string|max:255|unique:services,slug,' . $service->id,
        'description_en' => 'nullable|string',
        'description_ar' => 'nullable|string',
        'price'      => 'required|numeric|min:0',
        'currency'   => 'required|string|max:10',
        'unit_en'    => 'nullable|string|max:50',
        'unit_ar'    => 'nullable|string|max:50',
        'cover_image'=> 'nullable|image|max:2048',

        /* meta */
        'meta_title_en'        => 'nullable|string|max:255',
        'meta_title_ar'        => 'nullable|string|max:255',
        'meta_description_en'  => 'nullable|string|max:255',
        'meta_description_ar'  => 'nullable|string|max:255',
        'meta_keywords_en'     => 'nullable|string|max:255',
        'meta_keywords_ar'     => 'nullable|string|max:255',

        /* NEW / EXTRA image-update arrays */
        'service_images'           => 'nullable|array',
        'service_images.*'         => 'image|max:2048',

        'existing_image_ids'       => 'nullable|array',
        'existing_image_ids.*'     => 'integer|exists:service_images,id',

        'replace_service_images'   => 'nullable|array',
        'replace_service_images.*' => 'image|max:2048',

        'alt_texts_en'             => 'nullable|array',
        'alt_texts_en.*'           => 'nullable|string|max:255',
        'alt_texts_ar'             => 'nullable|array',
        'alt_texts_ar.*'           => 'nullable|string|max:255',

        'remove_images'            => 'nullable|array',
        'remove_images.*'          => 'integer|exists:service_images,id',

        'main_image'               => 'nullable|integer|exists:service_images,id',
    ]);

    /* ───── 2. Basic service data + cover image ─────────────────── */
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title_en']);
    }

    if ($request->hasFile('cover_image')) {
        // delete old
        if ($service->cover_image) {
            Storage::disk('public')->delete($service->cover_image);
        }
        $validated['cover_image'] = $request->file('cover_image')
                                           ->store('services/covers', 'public');
    }

    $service->update($validated);

    /* ───── 3. Gallery: DELETE unwanted images ──────────────────── */
    foreach ($request->input('remove_images', []) as $imgId) {
        if ($img = ServiceImage::find($imgId)) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
    }

    /* ───── 4. Gallery: UPDATE existing ones ────────────────────── */
    foreach ($request->input('existing_image_ids', []) as $idx => $imgId) {
        $img = ServiceImage::find($imgId);
        if (!$img) continue;

        // optional file replacement
        if ($request->hasFile("replace_service_images.$idx")) {
            Storage::disk('public')->delete($img->image_path);
            $newPath = $request->file("replace_service_images.$idx")
                               ->store('services/images', 'public');
            $img->image_path = $newPath;
        }

        $img->alt_text_en = $request->input("alt_texts_en.$idx");
        $img->alt_text_ar = $request->input("alt_texts_ar.$idx");
        $img->save();
    }

    /* ───── 5. Gallery: ADD brand-new uploads ───────────────────── */
    foreach ($request->file('service_images', []) as $idx => $file) {
        $service->images()->create([
            'image_path'  => $file->store('services/images', 'public'),
            'alt_text_en' => $request->input("image_alt_text_en.$idx"),
            'alt_text_ar' => $request->input("image_alt_text_ar.$idx"),
            'is_main'     => false,
        ]);
    }

    /* ───── 6. Main-image flag (radio) ──────────────────────────── */
    if ($request->filled('main_image')) {
        $service->images()->update(['is_main' => false]);
        $service->images()
                ->where('id', $request->input('main_image'))
                ->update(['is_main' => true]);
    }

    /* ───── 7. Done ─────────────────────────────────────────────── */
    return redirect()
           ->route('admin.services.index')
           ->with('success', 'Service updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        // Delete cover image
        if ($service->cover_image) {
            Storage::disk('public')->delete($service->cover_image);
        }
        
        // Delete service images
        foreach ($service->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the service (images will be deleted by the cascade on delete constraint)
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
    
    /**
     * Delete a service image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $image = ServiceImage::findOrFail($id);
        
        // Delete image file
        Storage::disk('public')->delete($image->image_path);
        
        // Delete image record
        $image->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Update service image details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request, $id)
    {
        $image = ServiceImage::findOrFail($id);
        
        $validated = $request->validate([
            'alt_text_en' => 'nullable|string|max:255',
            'alt_text_ar' => 'nullable|string|max:255',
            'is_main' => 'nullable|boolean',
        ]);
        
        // If setting as main, remove main flag from other images
        if (isset($validated['is_main']) && $validated['is_main']) {
            $image->service->images()->where('id', '!=', $image->id)->update(['is_main' => false]);
        }
        
        $image->update($validated);
        
        return response()->json(['success' => true]);
    }
}