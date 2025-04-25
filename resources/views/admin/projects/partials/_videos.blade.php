<div id="video-entries-container">

    {{-- stored videos --------------------------------------------------}}
    @if(isset($project) && $project->videos->count())
        @foreach($project->videos as $vid)
        <div class="video-entry border rounded p-3 mb-3">
            <input type="hidden" name="existing_video_ids[]" value="{{ $vid->id }}">

            <div class="row g-3">
                <div class="col-md-12">
                    {{-- quick playable preview (local vs. external) --}}
                    @if(str_starts_with($vid->video_url,'http'))
                        <a  href="{{ asset('storage/'.$vid->video_url) }}"
                            target="_blank"
                            class="btn btn-outline-info btn-sm mb-2">
                            <i class="bi bi-box-arrow-up-right"></i> Watch
                        </a>
                    @else
                        <video  src="{{ asset('storage/'.$vid->video_url) }}"
                                controls class="w-100 mb-2" style="max-height:200px;"></video>
                    @endif
                </div>

                {{-- ✦ captions ************************************************--}}
                <div class="col-md-6">
                    <input  type="text"
                            name="existing_video_captions_en[]"
                            class="form-control"
                            value="{{ $vid->caption_en }}"
                            placeholder="Caption (EN)">
                </div>
                <div class="col-md-6">
                    <input  type="text"
                            name="existing_video_captions_ar[]"
                            class="form-control"
                            value="{{ $vid->caption_ar }}"
                            placeholder="Caption (AR)">
                </div>

                {{-- replacement video file ------------------------------------}}
                <div class="col-md-12">
                    <input  type="file"
                            name="replace_video_files[]"
                            class="form-control video-file-input"
                            accept="video/*">
                </div>

                {{-- thumbnail + alt texts -------------------------------------}}
                <div class="col-md-6">
                    @if($vid->thumbnail_path)
                        <div class="thumbnail-preview text-center mb-2">
                            <img src="{{ asset('storage/'.$vid->thumbnail_path) }}"
                                 class="img-thumbnail" style="max-height:100px;">
                        </div>
                    @endif
                    <input  type="file"
                            name="video_thumbnails[]"
                            class="form-control thumbnail-input"
                            accept="image/*">
                </div>
                <div class="col-md-6">
                    <input  type="text"
                            name="thumbnail_alt_en[]"
                            class="form-control"
                            value="{{ $vid->thumbnail_alt_en }}"
                            placeholder="Thumb Alt (EN)">
                    <input  type="text"
                            name="thumbnail_alt_ar[]"
                            class="form-control mt-1"
                            value="{{ $vid->thumbnail_alt_ar }}"
                            placeholder="Thumb Alt (AR)">
                </div>
            </div>

            <div class="text-end mt-2">
                <button type="button"
                        class="btn btn-sm btn-outline-danger remove-video-entry">
                    Remove
                </button>
            </div>
        </div>
        @endforeach
    @endif


    {{-- hidden template used by JS --------------------------------------}}
    <div class="video-entry video-entry-template d-none border rounded p-3 mb-3">
        {{-- identical markup but with ***video_captions_en[] / video_captions_ar[]*** --}}
    </div>
</div>

<div class="text-center mt-3">
    <button type="button" class="btn btn-primary" id="add-video-entry">
        <i class="bi bi-plus-circle me-1"></i> Add Another Video
    </button>
</div>