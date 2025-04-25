<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_ar' => 'nullable|string',
            'full_description_en' => 'nullable|string',
            'full_description_ar' => 'nullable|string',
            'role_en' => 'nullable|string|max:255',
            'role_ar' => 'nullable|string|max:255',
            'duration_en' => 'nullable|string|max:100',
            'duration_ar' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer|exists:categories,id',
            'github_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'cover_image' => 'nullable|file|image',
            'featured' => 'boolean',

            // Tags
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',

            // New: project images
            'project_images' => 'nullable|array',
            'project_images.*' => 'file|image',
            'image_alt_text_en' => 'nullable|array',
            'image_alt_text_en.*' => 'nullable|string|max:255',
            'image_alt_text_ar' => 'nullable|array',
            'image_alt_text_ar.*' => 'nullable|string|max:255',

            // New: video files & titles
            'video_files' => 'nullable|array',
            'video_files.*' => 'file|mimetypes:video/mp4,video/webm,video/ogg',
            'video_captions_en' => 'nullable|array',
            'video_captions_en.*' => 'nullable|string|max:255',
            'video_captions_ar' => 'nullable|array',
            'video_captions_ar.*' => 'nullable|string|max:255',

            'existing_video_captions_en' => 'nullable|array',
            'existing_video_captions_en.*' => 'nullable|string|max:255',
            'existing_video_captions_ar' => 'nullable|array',
            'existing_video_captions_ar.*' => 'nullable|string|max:255',

            // Optional: existing‐video handling
            'existing_video_ids' => 'nullable|array',
            'existing_video_ids.*' => 'integer|exists:project_videos,id',
            'remove_videos' => 'nullable|array',
            'remove_videos.*' => 'integer|exists:project_videos,id',
        ];
    }
}
