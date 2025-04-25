{{-- resources/views/admin/projects/partials/_basic.blade.php --}}
<div class="row g-3">
{{-- ─── Cover Image ─────────────────────────────────────────────── --}}
<div class="col-md-12">
    <label for="cover_image" class="form-label">
        {{ __('Cover Image') }}
        <small class="text-muted">(JPG • PNG • max 2 MB)</small>
    </label>

    <input  type="file"
            name="cover_image"
            id="cover_image"
            class="form-control @error('cover_image') is-invalid @enderror"
            accept="image/*">

    {{-- validation error --}}
    @error('cover_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    {{-- preview of current image (edit mode only) --}}
    @isset($project->cover_image)
        <div class="mt-3">
            <img  src="{{ asset('storage/'.$project->cover_image) }}"
                  alt="Current Cover"
                  class="img-thumbnail"
                  style="max-height:150px;">
            <p class="text-muted mb-0">{{ __('Current cover image') }}</p>
        </div>
    @endisset
</div>
{{-- ─────────────────────────────────────────────────────────────── --}}
    {{-- titles --}}
    <div class="col-md-6">
        <label class="form-label" for="title_en">Title (EN) <span class="text-danger">*</span></label>
        <input type="text" id="title_en" name="title_en"
               class="form-control @error('title_en') is-invalid @enderror"
               value="{{ old('title_en', $project->title_en ?? '') }}" required>
        @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="title_ar">Title (AR) <span class="text-danger">*</span></label>
        <input type="text" id="title_ar" name="title_ar"
               class="form-control @error('title_ar') is-invalid @enderror"
               value="{{ old('title_ar', $project->title_ar ?? '') }}" required>
        @error('title_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- slug & category --}}
    <div class="col-md-6">
        <label class="form-label" for="slug">Slug <span class="text-danger">*</span></label>
        <input type="text" id="slug" name="slug"
               class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug', $project->slug ?? '') }}" required>
        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
        <select id="category_id" name="category_id"
                class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                        {{ old('category_id', $project->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name_en }}
                </option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Featured checkbox --}}
    <div class="col-md-12">
        <div class="form-check form-switch">
            {{-- fallback when unchecked --}}
            <input type="hidden" name="featured" value="0">
    
            {{-- real toggle --}}
            <input  class="form-check-input"
                    type="checkbox"
                    id="featured"
                    name="featured"
                    value="1"
                    {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}>
    
            <label class="form-check-label" for="featured">Featured Project</label>
        </div>
    </div>

    {{-- Project URLs --}}
    <div class="col-md-6">
        <label class="form-label" for="github_url">GitHub URL</label>
        <input type="url" id="github_url" name="github_url"
               class="form-control @error('github_url') is-invalid @enderror"
               value="{{ old('github_url', $project->github_url ?? '') }}">
        @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="demo_url">Demo URL</label>
        <input type="url" id="demo_url" name="demo_url"
               class="form-control @error('demo_url') is-invalid @enderror"
               value="{{ old('demo_url', $project->demo_url ?? '') }}">
        @error('demo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Project details --}}
    <div class="col-md-6">
        <label class="form-label" for="role_en">Role/Position (EN)</label>
        <input type="text" id="role_en" name="role_en"
               class="form-control @error('role_en') is-invalid @enderror"
               value="{{ old('role_en', $project->role_en ?? '') }}">
        @error('role_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="role_ar">Role/Position (AR)</label>
        <input type="text" id="role_ar" name="role_ar"
               class="form-control @error('role_ar') is-invalid @enderror"
               value="{{ old('role_ar', $project->role_ar ?? '') }}">
        @error('role_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="duration_en">Duration/Timeframe (EN)</label>
        <input type="text" id="duration_en" name="duration_en"
               class="form-control @error('duration_en') is-invalid @enderror"
               value="{{ old('duration_en', $project->duration_en ?? '') }}">
        @error('duration_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="duration_ar">Duration/Timeframe (AR)</label>
        <input type="text" id="duration_ar" name="duration_ar"
               class="form-control @error('duration_ar') is-invalid @enderror"
               value="{{ old('duration_ar', $project->duration_ar ?? '') }}">
        @error('duration_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- tags & tech --}}
    <div class="col-md-6">
        <label class="form-label">Tags</label>
        <select name="tags[]" class="form-select select2-multiple" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"
                        {{ isset($project) && $project->tags->contains($tag->id) ? 'selected' : '' }}>
                    {{ $tag->name_en }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Technologies</label>
        <select name="technologies[]" class="form-select select2-multiple" multiple>
            @foreach($technologies as $tech)
                <option value="{{ $tech->id }}"
                        {{ isset($project) && $project->technologies->contains($tech->id) ? 'selected' : '' }}>
                    {{ $tech->name_en }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- short descriptions --}}
    <div class="col-md-6">
        <label class="form-label">Short Description (EN)</label>
        <textarea name="short_description_en" class="form-control" rows="3">{{ old('short_description_en', $project->short_description_en ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Short Description (AR)</label>
        <textarea name="short_description_ar" class="form-control" rows="3">{{ old('short_description_ar', $project->short_description_ar ?? '') }}</textarea>
    </div>

    {{-- full descriptions with Quill --}}
    <div class="col-md-6">
        <label class="form-label">Full Description (EN)</label>
        <div id="editor_en">{!! old('full_description_en', $project->full_description_en ?? '') !!}</div>
        <input type="hidden" name="full_description_en" id="full_description_en">
    </div>

    <div class="col-md-6">
        <label class="form-label">Full Description (AR)</label>
        <div id="editor_ar">{!! old('full_description_ar', $project->full_description_ar ?? '') !!}</div>
        <input type="hidden" name="full_description_ar" id="full_description_ar">
    </div>

</div>

