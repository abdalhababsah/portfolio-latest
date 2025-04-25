{{-- ─── IMAGE REPEATER CONTAINER ─────────────────────────────────── --}}
<div id="image-entries-container">

    {{-- show each saved image as a normal .image-entry --}}
    @if(isset($project) && $project->images->count())
        @foreach($project->images as $img)
            <div class="image-entry border rounded p-3 mb-3">
                {{-- keep a reference to the DB row --}}
                <input type="hidden" name="existing_image_ids[]" value="{{ $img->id }}">

                <div class="row g-3">
                    <div class="col-md-12">
                        {{-- Preview --}}
                        <div class="image-preview text-center">
                            <img src="{{ Storage::url($img->image_path) }}"
                                 class="img-thumbnail" style="max-height:150px;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="existing_image_alt_text_en[]" class="form-control"
                               value="{{ $img->alt_text_en }}" placeholder="Alt (EN)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="existing_image_alt_text_ar[]" class="form-control"
                               value="{{ $img->alt_text_ar }}" placeholder="Alt (AR)">
                    </div>

                    <div class="col-md-12">
                        {{-- (optional) allow a replacement upload --}}
                        <input type="file" name="replace_project_images[]" class="form-control project-image-input mt-2"
                               accept="image/*">
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="button"
                            class="btn btn-sm btn-outline-danger remove-image-entry">Remove</button>
                </div>
            </div>
        @endforeach
    @endif

    {{-- visible empty entry for NEW uploads --}}
    <div class="image-entry border rounded p-3 mb-3">
        <div class="row g-3">
            <div class="col-md-12 mb-2">
                <label class="form-label">Select Image</label>
                <input type="file" name="project_images[]" class="form-control project-image-input" accept="image/*">
            </div>
            <div class="col-md-6">
                <input type="text" name="image_alt_text_en[]" class="form-control" placeholder="Alt (EN)">
            </div>
            <div class="col-md-6">
                <input type="text" name="image_alt_text_ar[]" class="form-control" placeholder="Alt (AR)">
            </div>
            <div class="col-md-12 image-preview d-none text-center">
                <img class="img-thumbnail" style="max-height:150px;">
            </div>
        </div>
        <div class="text-end mt-2">
            <button type="button" class="btn btn-sm btn-outline-danger remove-image-entry">Remove</button>
        </div>
    </div>

    {{-- HIDDEN TEMPLATE (unchanged) --}}
    <div class="image-entry image-entry-template d-none border rounded p-3 mb-3">
        {{-- …same markup as before… --}}
    </div>
</div>

<div class="text-center mt-3">
    <button type="button" class="btn btn-primary" id="add-image-entry">
        <i class="bi bi-plus-circle me-1"></i> Add Another Image
    </button>
</div>