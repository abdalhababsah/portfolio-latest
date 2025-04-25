<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Technology;
use App\Models\ProjectImage;
use App\Models\ProjectVideo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;

class AdminProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $projects = Project::with(['category', 'tags', 'images', 'videos'])->get();
            // dd($projects);

            return view('admin.projects.index', compact('projects'));
        } catch (Exception $e) {
            Log::error('Error loading projects index: ' . $e->getMessage());
            return back()->with('error', 'Failed to load projects.');
        }
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $technologies = Technology::all();
        return view('admin.projects.create-update', compact('categories', 'tags', 'technologies'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle cover image
            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('projects/covers', 'public');
            }

            // Set featured flag
            $data['featured'] = $request->has('featured');

            // Create the project
            $project = Project::create($data);

            // Sync tags
            $project->tags()->sync($request->input('tags', []));

            // Sync technologies
            $project->technologies()->sync($request->input('technologies', []));

            // Handle multiple project images
            if ($request->hasFile('project_images')) {
                foreach ($request->file('project_images') as $index => $image) {
                    $imagePath = $image->store('projects/images', 'public');
                    
                    // Get alt text for this image if provided
                    $altTextEn = $request->input('image_alt_text_en')[$index] ?? null;
                    $altTextAr = $request->input('image_alt_text_ar')[$index] ?? null;
                    
                    $project->images()->create([
                        'image_path' => $imagePath,
                        'alt_text_en' => $altTextEn,
                        'alt_text_ar' => $altTextAr,
                        'is_main' => ($index === 0) // First image is main by default
                    ]);
                }
            }

            if ($request->hasFile('video_files')) {
                foreach ($request->file('video_files') as $index => $file) {
                    $path = $file->store('projects/videos', 'public');
                    $project->videos()->create([
                        'video_url'  => $path,
                        'caption_en'   => $request->input('video_captions_en')[$index] ?? null,
                        'caption_ar'   => $request->input('video_captions_ar')[$index] ?? null,
                    ]);
                }
            }

            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $project = Project::with(['tags', 'technologies', 'images', 'videos'])->findOrFail($id);
            $categories = Category::all();
            $tags = Tag::all();
            $technologies = Technology::all();

            return view('admin.projects.create-update', compact('project', 'categories', 'tags', 'technologies'));
        } catch (Exception $e) {
            Log::error("Error editing project [ID: $id]: " . $e->getMessage());
            return redirect()->route('admin.projects.index')->with('error', 'Project not found.');
        }
    }

/**
 * Update an existing project.
 *
 * @param  \App\Http\Requests\StoreProjectRequest  $request
 * @param  int  $id
 * @return \Illuminate\Http\RedirectResponse
 */


public function update(StoreProjectRequest $request, int $id)
{
    DB::beginTransaction();

    try {
        /* ------------------------------------------------------------------
         | 1.  Find project & basic columns
         * -----------------------------------------------------------------*/
        $project         = Project::findOrFail($id);
        $data            = $request->all();
        $data['featured'] = $request->boolean('featured');

        /* cover image ----------------------------------------------------*/
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image &&
                Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] =
                $request->file('cover_image')->store('projects/covers','public');
        }
        $project->update($data);

        /* ------------------------------------------------------------------
         | 2.  Many-to-many
         * -----------------------------------------------------------------*/
        $project->tags()->sync($request->input('tags'        , []));
        $project->technologies()
                ->sync($request->input('technologies', []));

        /* ================================================================
         | 3.  IMAGES
         * ===============================================================*/
        // a) remove -------------------------------------------------------
        foreach ($request->input('remove_images', []) as $imgId) {
            if ($img = ProjectImage::find($imgId)) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // b) update / replace existing -----------------------------------
        foreach ($request->input('existing_image_ids', []) as $idx => $imgId) {
            if (! $img = ProjectImage::find($imgId)) continue;

            // optional replacement file
            if ($request->hasFile("replace_project_images.$idx")) {
                Storage::disk('public')->delete($img->image_path);
                $newPath = $request->file("replace_project_images.$idx")
                                   ->store('projects/images','public');
                $img->image_path = $newPath;
            }

            $img->alt_text_en = $request->input("existing_image_alt_text_en.$idx");
            $img->alt_text_ar = $request->input("existing_image_alt_text_ar.$idx");
            $img->is_main     = $request->input('main_image') == $imgId;
            $img->save();
        }

        // c) brand-new images -------------------------------------------
        foreach ($request->file('project_images', []) as $idx => $file) {
            $project->images()->create([
                'image_path'  => $file->store('projects/images','public'),
                'alt_text_en' => $request->input("image_alt_text_en.$idx"),
                'alt_text_ar' => $request->input("image_alt_text_ar.$idx"),
                'is_main'     => false,
            ]);
        }

        /* ================================================================
         | 4.  VIDEOS
         * ===============================================================*/
        // a) remove -------------------------------------------------------
        $project->videos()->whereIn('id', $request->input('remove_videos', []))
                          ->delete();

        // b) update / replace existing -----------------------------------
        foreach ($request->input('existing_video_ids', []) as $idx => $vidId) {
            if (! $vid = $project->videos()->find($vidId)) continue;

            // optional replacement video
            if ($request->hasFile("replace_video_files.$idx")) {
                $vidPath = $request->file("replace_video_files.$idx")
                                   ->store('projects/videos','public');
                $vid->video_url = $vidPath;
            }

            // optional replacement thumbnail
            if ($request->hasFile("video_thumbnails.$idx")) {
                if ($vid->thumbnail_path) {
                    Storage::disk('public')->delete($vid->thumbnail_path);
                }
                $thumbPath = $request->file("video_thumbnails.$idx")
                                     ->store('projects/videos/thumbnails','public');
                $vid->thumbnail_path = $thumbPath;
            }

            $vid->caption_en       = $request->input("existing_video_captions_en.$idx");
            $vid->caption_ar       = $request->input("existing_video_captions_ar.$idx");
            $vid->thumbnail_alt_en = $request->input("thumbnail_alt_en.$idx");
            $vid->thumbnail_alt_ar = $request->input("thumbnail_alt_ar.$idx");
            $vid->save();
        }

        // c) brand-new videos -------------------------------------------
        foreach ($request->file('video_files', []) as $idx => $file) {
            $videoPath = $file->store('projects/videos','public');

            // thumbnail for this new video (same index)
            $thumbPath = null;
            if ($request->hasFile("video_thumbnails.$idx")) {
                $thumbPath = $request->file("video_thumbnails.$idx")
                                     ->store('projects/videos/thumbnails','public');
            }

            $project->videos()->create([
                'video_url'        => $videoPath,
                'caption_en'       => $request->input("video_captions_en.$idx"),
                'caption_ar'       => $request->input("video_captions_ar.$idx"),
                'thumbnail_path'   => $thumbPath,
                'thumbnail_alt_en' => $request->input("thumbnail_alt_en.$idx"),
                'thumbnail_alt_ar' => $request->input("thumbnail_alt_ar.$idx"),
            ]);
        }

        /* ----------------------------------------------------------------
         | 5.  Done
         * ---------------------------------------------------------------*/
        DB::commit();
        return redirect()
               ->route('admin.projects.index')
               ->with('success','Project updated successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error("Project update failed [ID:$id] : ".$e->getMessage(),[
            'trace' => $e->getTraceAsString()
        ]);
        return back()
               ->withInput()
               ->with('error','Failed to update project – please check the form.');
    }
}

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        try {
            // Delete associated images
            foreach ($project->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            // Delete cover image
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }

            // Delete the project (this will cascade delete images and videos due to foreign keys)
            $project->delete();

            return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
        } catch (Exception $e) {
            Log::error("Error deleting project [ID: {$project->id}]: " . $e->getMessage());
            return redirect()->route('admin.projects.index')->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }
   /**
     * Update the main image for a project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setMainImage(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            $imageId = $request->input('image_id');
            
            // First reset all images to not be main
            $project->images()->update(['is_main' => false]);
            
            // Then set the selected image as main
            $image = $project->images()->findOrFail($imageId);
            $image->is_main = true;
            $image->save();
            
            return redirect()->back()->with('success', 'Main image updated successfully.');
        } catch (Exception $e) {
            Log::error("Error setting main image for project [ID: $id]: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update main image.');
        }
    }

    /**
     * Delete a specific video from a project.
     *
     * @param  int  $id
     * @param  int  $videoId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteVideo($id, $videoId)
    {
        try {
            $project = Project::findOrFail($id);
            $video = $project->videos()->findOrFail($videoId);
            
            // Delete the video record
            $video->delete();
            
            return redirect()->back()->with('success', 'Video deleted successfully.');
        } catch (Exception $e) {
            Log::error("Error deleting video [ID: $videoId] for project [ID: $id]: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete video.');
        }
    }
    /**
     * Toggle the featured status of a project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleFeatured($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->featured = !$project->featured;
            $project->save();
            
            $status = $project->featured ? 'featured' : 'unfeatured';
            return redirect()->back()->with('success', "Project has been $status.");
        } catch (Exception $e) {
            Log::error("Error toggling featured status for project [ID: $id]: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update featured status.');
        }
    }
        /**
     * Delete a specific image from a project.
     *
     * @param  int  $id
     * @param  int  $imageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage($id, $imageId)
    {
        try {
            $project = Project::findOrFail($id);
            $image = $project->images()->findOrFail($imageId);
            
            // Delete the image file
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            // Delete the image record
            $image->delete();
            
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } catch (Exception $e) {
            Log::error("Error deleting image [ID: $imageId] for project [ID: $id]: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete image.');
        }
    }
}
