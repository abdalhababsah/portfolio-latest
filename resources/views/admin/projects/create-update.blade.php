@extends('admin.layout.app')

@section('content')
    <div class="page-container">
        {{-- PAGE TITLE --}}

        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">
                    {{ isset($project) ? 'Edit Project' : 'Create Project' }}
                </h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                    <li class="breadcrumb-item active">{{ isset($project) ? 'Edit' : 'Create' }}</li>
                </ol>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops! </strong>There were some problems with your input:
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- MAIN FORM --}}
        <form id="projectForm"
            action="{{ isset($project) ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($project))
                @method('PUT')
            @endif

            <div class="card">
                <div class="card-body">

                    {{-- NAV TABS (Bootstrap wizard style) --}}
                    <ul class="nav nav-pills nav-justified form-wizard-header mb-4" id="projectWizardTabs">
                        <li class="nav-item"><a class="nav-link active rounded-0 py-2" data-bs-toggle="tab"
                                href="#step1"><i class="bi bi-file-earmark-text fs-18 me-1"></i><span
                                    class="d-none d-sm-inline">Basic</span></a></li>
                        <li class="nav-item"><a class="nav-link rounded-0 py-2" data-bs-toggle="tab" href="#step2"><i
                                    class="bi bi-images fs-18 me-1"></i><span class="d-none d-sm-inline">Images</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link rounded-0 py-2" data-bs-toggle="tab" href="#step3"><i
                                    class="bi bi-camera-video fs-18 me-1"></i><span
                                    class="d-none d-sm-inline">Videos</span></a></li>
                        <li class="nav-item"><a class="nav-link rounded-0 py-2" data-bs-toggle="tab" href="#step4"><i
                                    class="bi bi-gear fs-18 me-1"></i><span class="d-none d-sm-inline">Meta</span></a></li>
                    </ul>

                    {{-- TAB PANES --}}
                    <div class="tab-content" id="projectWizardContent">

                        {{-- STEP 1 – BASIC INFO --}}
                        <div class="tab-pane fade show active" id="step1">
                            @include('admin.projects.partials._basic')
                        </div>

                        {{-- STEP 2 – IMAGES --}}
                        <div class="tab-pane fade" id="step2">
                            @include('admin.projects.partials._images')
                        </div>

                        {{-- STEP 3 – VIDEOS --}}
                        <div class="tab-pane fade" id="step3">
                            @include('admin.projects.partials._videos')
                        </div>

                        {{-- STEP 4 – META --}}
                        <div class="tab-pane fade" id="step4">
                            @include('admin.projects.partials._meta')
                        </div>
                    </div>

                    {{-- WIZARD BUTTONS --}}
                    <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-4" style="margin-top:90px !important;">
                        <button type="button" class="btn btn-secondary px-4" id="prevTab"><i
                                class="bi bi-arrow-left me-1"></i>Previous</button>
                        <button type="button" class="btn btn-primary px-4" id="nextTab">Next<i
                                class="bi bi-arrow-right ms-1"></i></button>
                        <button type="submit" class="btn btn-success px-4" id="finishBtn"><i
                                class="bi bi-check-circle me-1"></i>{{ isset($project) ? 'Update' : 'Save' }}</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /* ---------- Wizard (Bootstrap pills) ---------- */
            const $tabs = $('#projectWizardTabs .nav-link');
            let idx = 0;
            const showTab = i => {
                $tabs.eq(i).tab('show');
                $('#prevTab').toggle(i > 0);
                $('#nextTab').toggle(i < $tabs.length - 1);
                $('#finishBtn').toggle(i === $tabs.length - 1);
                idx = i;
            };
            /* ---------- keep buttons in‑sync when user clicks a tab ---------- */
            $tabs.on('shown.bs.tab', function (e) {
                // index of the newly activated tab
                idx = $(e.target).closest('.nav-item').index();

                // toggle buttons just like showTab() does
                $('#prevTab').toggle(idx > 0);
                $('#nextTab').toggle(idx < $tabs.length - 1);
                $('#finishBtn').toggle(idx === $tabs.length - 1);
            });
            $('#nextTab').on('click', () => showTab(Math.min(idx + 1, $tabs.length - 1)));
            $('#prevTab').on('click', () => showTab(Math.max(idx - 1, 0)));
            showTab(0);

            /* ---------- Select2 ---------- */
            $('.select2-multiple').select2({
                width: '100%'
            });

            /* ---------- Quill Editors ---------- */
            const quillEn = new Quill('#editor_en', {
                theme: 'snow'
            });
            const quillAr = new Quill('#editor_ar', {
                theme: 'snow'
            });
            $('#projectForm').on('submit', function() {
                $('#full_description_en').val(quillEn.root.innerHTML);
                $('#full_description_ar').val(quillAr.root.innerHTML);
            });

            /* ---------- Image Preview ---------- */
            const imageInput = document.getElementById('project_images');
            const imagePreviewContainer = document.getElementById('image-preview-container');

            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    // Clear previous previews
                    imagePreviewContainer.innerHTML = '';

                    // Create previews for each selected file
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];

                        // Only process image files
                        if (!file.type.match('image.*')) {
                            continue;
                        }

                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const previewCol = document.createElement('div');
                            previewCol.className = 'col-md-3 mb-3';

                            previewCol.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" alt="Preview" style="height:150px;object-fit:cover">
                            <div class="card-body p-2">
                                <p class="card-text text-truncate mb-1">${file.name}</p>
                                <input type="text" name="image_alt_text_en[]" class="form-control form-control-sm mb-1" placeholder="Alt Text (EN)">
                                <input type="text" name="image_alt_text_ar[]" class="form-control form-control-sm" placeholder="Alt Text (AR)">
                            </div>
                        </div>
                    `;

                            imagePreviewContainer.appendChild(previewCol);
                        };

                        reader.readAsDataURL(file);
                    }
                });
            }

            /* ---------- Video Preview ---------- */
            const videoInput = document.getElementById('video_files');
            const videoPreviewContainer = document.getElementById('video-preview-container');

            if (videoInput) {
                videoInput.addEventListener('change', function() {
                    // Clear previous previews
                    videoPreviewContainer.innerHTML = '';

                    // Create previews for each selected file
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];

                        // Only process video files
                        if (!file.type.match('video.*')) {
                            continue;
                        }

                        const previewRow = document.createElement('div');
                        previewRow.className = 'row mb-3 align-items-center';

                        previewRow.innerHTML = `
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center py-3">
                                <i class="ti ti-video fs-36 text-primary"></i>
                                <p class="mb-0 text-truncate">${file.name}</p>
                                <small class="text-muted">${(file.size / (1024 * 1024)).toFixed(2)} MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="video_titles_en[]" class="form-control mb-2" placeholder="Title (EN)">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="video_titles_ar[]" class="form-control" placeholder="Title (AR)">
                    </div>
                `;

                        videoPreviewContainer.appendChild(previewRow);
                    }
                });
            }
        });
        $(function() {

            /* ───────────────────────────────
               IMAGE   R E P E A T E R
            ─────────────────────────────── */
            const $imgC = $('#image-entries-container');

            // helper: returns fresh HTML
            const imageEntry = () => `
    <div class="image-entry border rounded p-3 mb-3">
        <div class="row g-3">
            <div class="col-md-12 mb-2">
                <label class="form-label">Select Image</label>
                <input type="file" name="project_images[]" class="form-control project-image-input" accept="image/*">
            </div>
            <div class="col-md-6">
                <input type="text" name="image_alt_text_en[]" class="form-control" placeholder="Alt Text (EN)">
            </div>
            <div class="col-md-6">
                <input type="text" name="image_alt_text_ar[]" class="form-control" placeholder="Alt Text (AR)">
            </div>
            <div class="col-md-12 image-preview d-none text-center">
                <img class="img-thumbnail" style="max-height:150px;">
            </div>
        </div>
        <div class="text-end mt-2">
            <button type="button" class="btn btn-sm btn-outline-danger remove-image-entry">Remove</button>
        </div>
    </div>`;

            // add
            $('#add-image-entry').on('click', () => $imgC.append(imageEntry()));

            // remove
            $imgC.on('click', '.remove-image-entry', function() {
                const $e = $(this).closest('.image-entry');
                const imgId = $e.find('input[name="existing_image_ids[]"]').val(); // ← existing?

                /* ---------- tell backend to delete ---------- */
                if (imgId) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'remove_images[]',
                        value: imgId
                    }).appendTo('#projectForm'); //  ← ★★
                }

                /* ---------- front-end removal / reset -------- */
                if ($imgC.find('.image-entry').length > 1) {
                    $e.remove();
                } else {
                    $e.find('input[type="file"], input[type="text"]').val('');
                    $e.find('.image-preview').addClass('d-none')
                        .find('img').attr('src', '');
                }
            });

            // live preview
            $imgC.on('change', '.project-image-input', function() {
                const $prev = $(this).closest('.image-entry').find('.image-preview'),
                    $img = $prev.find('img');
                if (this.files && this.files[0]) {
                    const rdr = new FileReader();
                    rdr.onload = e => {
                        $img.attr('src', e.target.result);
                        $prev.removeClass('d-none');
                    };
                    rdr.readAsDataURL(this.files[0]);
                } else $prev.addClass('d-none');
            });


            /* ───────────────────────────────
               VIDEO   R E P E A T E R
            ─────────────────────────────── */
            /* === VIDEO REPEATER ================================================= */
            const $vidC = $('#video-entries-container');

            const videoEntry = () => `
  <div class="video-entry border rounded p-3 mb-3">
      <div class="row g-3">
          <div class="col-md-12 mb-2">
              <label class="form-label">Select Video File</label>
              <input  type="file"
                      name="video_files[]"
                      class="form-control video-file-input"
                      accept="video/*">
          </div>

          <div class="col-md-6">
              <input type="text"
                     name="video_captions_en[]"
                     class="form-control"
                     placeholder="Caption (EN)">
          </div>
          <div class="col-md-6">
              <input type="text"
                     name="video_captions_ar[]"
                     class="form-control"
                     placeholder="Caption (AR)">
          </div>

          <div class="col-md-12">
              <div class="row">
                  <div class="col-md-6">
                      <label class="form-label">Thumbnail (Optional)</label>
                      <input type="file"
                             name="video_thumbnails[]"
                             class="form-control thumbnail-input"
                             accept="image/*">
                  </div>
                  <div class="col-md-6">
                      <div class="thumbnail-preview d-none mt-2 text-center">
                          <img class="img-thumbnail" style="max-height:100px;">
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-md-6">
              <input type="text"
                     name="thumbnail_alt_en[]"
                     class="form-control"
                     placeholder="Thumb Alt (EN)">
          </div>
          <div class="col-md-6">
              <input type="text"
                     name="thumbnail_alt_ar[]"
                     class="form-control"
                     placeholder="Thumb Alt (AR)">
          </div>
      </div>

      <div class="text-end mt-2">
          <button type="button"
                  class="btn btn-sm btn-outline-danger remove-video-entry">
              Remove
          </button>
      </div>
  </div>`;

            $('#add-video-entry').on('click', () => $vidC.append(videoEntry()));

            /* ────────── remove a video entry ────────── */
            $vidC.on('click', '.remove-video-entry', function() {
                const $entry = $(this).closest('.video-entry'); // the card being removed
                const vidId = $entry.find('input[name="existing_video_ids[]"]').val();

                /* 1.  Tell the back-end to delete it (only if it was already in DB) */
                if (vidId) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'remove_videos[]',
                        value: vidId
                    }).appendTo('#projectForm');
                }

                /* 2.  Front-end behaviour */
                if ($vidC.find('.video-entry').length > 1) {
                    // more than one entry → just remove the whole block
                    $entry.remove();
                } else {
                    // it’s the only block → keep it, but reset its fields
                    $entry.find('input[type="file"], input[type="text"]').val('');
                    $entry.find('.thumbnail-preview')
                        .addClass('d-none')
                        .find('img').attr('src', '');
                    $entry.find('video').remove(); // drop any video preview
                }
            });

            // video file preview
            $vidC.on('change', '.video-file-input', function() {
                const $entry = $(this).closest('.video-entry');
                $entry.find('video').remove();

                if (this.files && this.files[0] && this.files[0].type.startsWith('video/')) {
                    const url = URL.createObjectURL(this.files[0]);
                    $(`<video class="w-100 mt-2" controls style="max-height:200px;">
               <source src="${url}" type="${this.files[0].type}">
           </video>`).appendTo($entry.find('.col-md-12').first());
                }
            });

            // thumbnail preview
            $vidC.on('change', '.thumbnail-input', function() {
                const $prev = $(this).closest('.row').find('.thumbnail-preview'),
                    $img = $prev.find('img');
                if (this.files && this.files[0]) {
                    const rdr = new FileReader();
                    rdr.onload = e => {
                        $img.attr('src', e.target.result);
                        $prev.removeClass('d-none');
                    };
                    rdr.readAsDataURL(this.files[0]);
                } else $prev.addClass('d-none');
            });

        });
    </script>
@endpush
