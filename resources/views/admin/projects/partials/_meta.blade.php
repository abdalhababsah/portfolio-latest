{{-- resources/views/admin/projects/partials/_meta.blade.php --}}
<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Meta Title (EN)</label>
        <input type="text" name="meta_title_en" class="form-control"
               value="{{ old('meta_title_en', $project->meta_title_en ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Title (AR)</label>
        <input type="text" name="meta_title_ar" class="form-control"
               value="{{ old('meta_title_ar', $project->meta_title_ar ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Description (EN)</label>
        <textarea name="meta_description_en" class="form-control" rows="3">{{ old('meta_description_en', $project->meta_description_en ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Description (AR)</label>
        <textarea name="meta_description_ar" class="form-control" rows="3">{{ old('meta_description_ar', $project->meta_description_ar ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Keywords (EN)</label>
        <textarea name="meta_keywords_en" class="form-control" rows="2"
                  placeholder="comma, separated">{{ old('meta_keywords_en', $project->meta_keywords_en ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Keywords (AR)</label>
        <textarea name="meta_keywords_ar" class="form-control" rows="2"
                  placeholder="comma, separated">{{ old('meta_keywords_ar', $project->meta_keywords_ar ?? '') }}</textarea>
    </div>

</div>