{{-- resources/views/admin/services/create-update.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="container-fluid pb-4">
    {{-- ───── Page header with animated indicator ─────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="position-relative">
            <h4 class="mb-0 fw-bold">
                {{ isset($service) ? 'Edit Service' : 'Create Service' }}
            </h4>
            <div class="progress mt-1" style="height: 4px; width: 60px;">
                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: 100%"></div>
            </div>
        </div>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to list
        </a>
    </div>

    {{-- ───── Flash message with fade animation ─────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ───── Validation errors summary ────────────────────────────────── --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-danger border-4">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please check the form for errors</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ───── Main form with tabs ─────────────────────────────────────────────────── --}}
    <form action="{{ isset($service) ? route('admin.services.update', $service->id) : route('admin.services.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="serviceForm">

        @csrf
        @isset($service) @method('PUT') @endisset

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-3">
                <ul class="nav nav-tabs card-header-tabs" id="serviceTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button">
                            <i class="fas fa-info-circle me-1"></i> Basic Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-tab-pane" type="button">
                            <i class="fas fa-images me-1"></i> Gallery
                            @isset($service)
                                <span class="badge bg-primary rounded-pill">{{ count($service->images) }}</span>
                            @endisset
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta-tab-pane" type="button">
                            <i class="fas fa-tags me-1"></i> SEO & Meta
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="serviceTabContent">
                    {{-- ─── 1. Basic Info Tab ───────────────────────────────────── --}}
                    <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            {{-- Cover image preview --}}
                                            <div class="col-md-3">
                                                <div class="position-relative mb-3">
                                                    <div class="cover-image-preview bg-white rounded border text-center p-2" style="min-height: 200px;">
                                                        @isset($service->cover_image)
                                                            <img src="{{ asset('storage/'.$service->cover_image) }}" 
                                                                 class="img-fluid preview-img" alt="Cover image">
                                                        @else
                                                            <div class="placeholder-img d-flex align-items-center justify-content-center h-100">
                                                                <i class="fas fa-image fa-3x text-muted"></i>
                                                            </div>
                                                        @endisset
                                                    </div>
                                                    
                                                    <div class="input-group mt-2">
                                                        <label class="input-group-text bg-primary text-white" for="coverImage">
                                                            <i class="fas fa-upload"></i>
                                                        </label>
                                                        <input type="file" 
                                                               id="coverImage"
                                                               name="cover_image" 
                                                               class="form-control @error('cover_image') is-invalid @enderror"
                                                               accept="image/*">
                                                    </div>
                                                    @error('cover_image')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            {{-- Basic form fields --}}
                                            <div class="col-md-9">
                                                <div class="row g-3">
                                                    {{-- Language tabs for titles --}}
                                                    <div class="col-12">
                                                        <nav>
                                                            <div class="nav nav-pills nav-fill" id="title-lang-tab">
                                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#title-en" type="button">
                                                                    <i class="fas fa-language me-1"></i> English
                                                                </button>
                                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#title-ar" type="button">
                                                                    <i class="fas fa-language me-1"></i> العربية
                                                                </button>
                                                            </div>
                                                        </nav>
                                                        
                                                        <div class="tab-content mt-2" id="title-lang-content">
                                                            <div class="tab-pane fade show active" id="title-en">
                                                                <label class="form-label">Title (EN) <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="title_en"
                                                                       class="form-control form-control-lg @error('title_en') is-invalid @enderror"
                                                                       value="{{ old('title_en', $service->title_en ?? '') }}"
                                                                       placeholder="Enter service title in English"
                                                                       required>
                                                                @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                            <div class="tab-pane fade" id="title-ar">
                                                                <label class="form-label">Title (AR) <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                       name="title_ar"
                                                                       class="form-control form-control-lg @error('title_ar') is-invalid @enderror"
                                                                       value="{{ old('title_ar', $service->title_ar ?? '') }}"
                                                                       placeholder="أدخل عنوان الخدمة بالعربية"
                                                                       dir="rtl"
                                                                       required>
                                                                @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    {{-- Slug with auto-generate --}}
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">Slug</span>
                                                            <input type="text"
                                                                   name="slug"
                                                                   id="slug-field"
                                                                   class="form-control @error('slug') is-invalid @enderror"
                                                                   value="{{ old('slug', $service->slug ?? '') }}"
                                                                   placeholder="service-slug">
                                                            <button class="btn btn-outline-secondary" type="button" id="generate-slug">
                                                                <i class="fas fa-sync-alt"></i> Generate
                                                            </button>
                                                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>
                                                        <small class="text-muted">Leave empty for auto-generation from title</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pricing section with cards --}}
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Pricing Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label d-flex justify-content-between">
                                                    <span>Price</span>
                                                    <span class="badge bg-secondary">Optional</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                    <input type="number"
                                                           name="price"
                                                           step="0.01"
                                                           class="form-control @error('price') is-invalid @enderror"
                                                           value="{{ old('price', $service->price ?? '') }}"
                                                           placeholder="0.00">
                                                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Currency</label>
                                                <select name="currency" class="form-select @error('currency') is-invalid @enderror">
                                                    @php $currencies = ['USD' => 'US Dollar ($)', 'EUR' => 'Euro (€)', 'GBP' => 'British Pound (£)', 'SAR' => 'Saudi Riyal (﷼)'] @endphp
                                                    @foreach($currencies as $code => $name)
                                                        <option value="{{ $code }}" {{ (old('currency', $service->currency ?? 'USD') == $code) ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Unit</label>
                                                <div class="btn-group w-100">
                                                    <input type="text"
                                                           name="unit_en" 
                                                           class="form-control"
                                                           value="{{ old('unit_en', $service->unit_en ?? '') }}"
                                                           placeholder="per hour (EN)">
                                                    <input type="text"
                                                           name="unit_ar"
                                                           class="form-control"
                                                           value="{{ old('unit_ar', $service->unit_ar ?? '') }}"
                                                           placeholder="في الساعة (AR)"
                                                           dir="rtl">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Description section with language tabs --}}
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-align-left me-2"></i>Description</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-pills mb-3" id="description-tabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="desc-en-tab" data-bs-toggle="pill" 
                                                        data-bs-target="#desc-en-content" type="button">English</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="desc-ar-tab" data-bs-toggle="pill" 
                                                        data-bs-target="#desc-ar-content" type="button">العربية</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="description-content">
                                            <div class="tab-pane fade show active" id="desc-en-content" role="tabpanel">
                                                <textarea name="description_en"
                                                          rows="4"
                                                          class="form-control"
                                                          placeholder="Enter service description in English">{{ old('description_en', $service->description_en ?? '') }}</textarea>
                                            </div>
                                            <div class="tab-pane fade" id="desc-ar-content" role="tabpanel">
                                                <textarea name="description_ar"
                                                          rows="4"
                                                          class="form-control"
                                                          dir="rtl"
                                                          placeholder="أدخل وصف الخدمة بالعربية">{{ old('description_ar', $service->description_ar ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ─── 2. Gallery Tab ───────────────────────────────────── --}}
                    <div class="tab-pane fade" id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-lightbulb me-2"></i> 
                                    Upload multiple images to showcase this service. One image can be set as the main gallery image.
                                </div>
                            </div>
                        </div>

                        {{-- Existing images gallery with visual enhancements --}}
                        @isset($service)
                            <h6 class="d-flex align-items-center mb-3">
                                <i class="fas fa-images me-2"></i> Current Gallery Images
                                <span class="badge bg-primary ms-2">{{ count($service->images) }}</span>
                            </h6>
                            
                            <div class="row g-3 mb-4" id="existing-images-gallery">
                                @foreach($service->images as $img)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card h-100 {{ $img->is_main ? 'border-primary' : 'border-light' }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/'.$img->image_path) }}"
                                                     class="card-img-top"
                                                     alt="{{ $img->alt_text_en }}"
                                                     style="height: 160px; object-fit: cover;">
                                                
                                                <input type="hidden" name="existing_image_ids[]" value="{{ $img->id }}">
                                                
                                                @if($img->is_main)
                                                    <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                                                        <i class="fas fa-star me-1"></i> Main
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="card-body p-2">
                                                <div class="mb-2">
                                                    <div class="form-floating mb-2">
                                                        <input type="text"
                                                               name="existing_image_alt_text_en[]"
                                                               class="form-control form-control-sm"
                                                               placeholder="Alt text (EN)"
                                                               value="{{ $img->alt_text_en }}">
                                                        <label>Alt text (EN)</label>
                                                    </div>
                                                    
                                                    <div class="form-floating">
                                                        <input type="text"
                                                               name="existing_image_alt_text_ar[]"
                                                               class="form-control form-control-sm"
                                                               placeholder="Alt text (AR)"
                                                               value="{{ $img->alt_text_ar }}"
                                                               dir="rtl">
                                                        <label>Alt text (AR)</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio"
                                                               name="main_image"
                                                               value="{{ $img->id }}"
                                                               id="main_{{ $img->id }}"
                                                               {{ $img->is_main ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="main_{{ $img->id }}">
                                                            Set as main
                                                        </label>
                                                    </div>
                                                    
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-existing-img">
                                                        <i class="fas fa-trash me-1"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endisset

                        {{-- New uploads with drag area --}}
                        <div class="card border-dashed border-primary my-4">
                            <div class="card-body text-center p-4">
                                <h6><i class="fas fa-cloud-upload-alt me-2"></i> Add New Images</h6>
                                <div id="new-image-container" class="row g-3 mt-3">
                                    <!-- Dynamic content here -->
                                </div>
                                
                                <button type="button" class="btn btn-primary mt-3" id="add-img">
                                    <i class="fas fa-plus-circle me-1"></i> Add image
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ─── 3. SEO & Meta Tab ───────────────────────────────────── --}}
                    <div class="tab-pane fade" id="meta-tab-pane" role="tabpanel" aria-labelledby="meta-tab">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> 
                                    These fields help improve your service visibility in search engines. If left empty, the basic information will be used.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            {{-- Meta title with preview --}}
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-heading me-2"></i>Meta Title</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title (EN)</label>
                                            <input type="text"
                                                   name="meta_title_en"
                                                   id="meta-title-en"
                                                   class="form-control"
                                                   value="{{ old('meta_title_en', $service->meta_title_en ?? '') }}"
                                                   placeholder="Enter SEO title in English">
                                            <div class="form-text">
                                                <span id="meta-title-en-counter" class="text-muted">0/60</span> characters
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title (AR)</label>
                                            <input type="text"
                                                   name="meta_title_ar"
                                                   id="meta-title-ar"
                                                   class="form-control"
                                                   value="{{ old('meta_title_ar', $service->meta_title_ar ?? '') }}"
                                                   dir="rtl"
                                                   placeholder="أدخل عنوان SEO بالعربية">
                                            <div class="form-text text-end">
                                                <span id="meta-title-ar-counter" class="text-muted">0/60</span> characters
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="seo-preview p-3 border rounded bg-light">
                                                <h6 class="text-primary mb-1" id="seo-preview-title">
                                                    {{ old('meta_title_en', $service->meta_title_en ?? ($service->title_en ?? 'Service Title Preview')) }}
                                                </h6>
                                                <div class="text-success small">www.yourwebsite.com/services/{{ old('slug', $service->slug ?? 'service-slug') }}</div>
                                                <p class="text-muted small mb-0 mt-1" id="seo-preview-desc">
                                                    {{ old('meta_description_en', $service->meta_description_en ?? 'Your meta description will appear here...') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Meta description --}}
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-align-left me-2"></i>Meta Description</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description (EN)</label>
                                            <textarea name="meta_description_en"
                                                      id="meta-desc-en"
                                                      rows="3"
                                                      class="form-control"
                                                      placeholder="Enter SEO description in English">{{ old('meta_description_en', $service->meta_description_en ?? '') }}</textarea>
                                            <div class="form-text">
                                                <span id="meta-desc-en-counter" class="text-muted">0/160</span> characters
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description (AR)</label>
                                            <textarea name="meta_description_ar"
                                                      id="meta-desc-ar"
                                                      rows="3"
                                                      class="form-control"
                                                      dir="rtl"
                                                      placeholder="أدخل وصف SEO بالعربية">{{ old('meta_description_ar', $service->meta_description_ar ?? '') }}</textarea>
                                            <div class="form-text text-end">
                                                <span id="meta-desc-ar-counter" class="text-muted">0/160</span> characters
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Bottom sticky action bar ───────────────────────────────────── --}}
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">
                        <i class="fas fa-clock me-1"></i> 
                        Last updated: {{ isset($service->updated_at) ? $service->updated_at->diffForHumans() : 'Never' }}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas {{ isset($service) ? 'fa-save' : 'fa-plus-circle' }} me-1"></i>
                        {{ isset($service) ? 'Update Service' : 'Create Service' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles */
    .border-dashed {
        border-style: dashed !important;
        border-width: 2px !important;
    }
    
    /* Tab transitions */
    .tab-pane.fade {
        transition: opacity 0.2s linear;
    }
    
    /* Image preview enhancements */
    .cover-image-preview {
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .cover-image-preview:hover {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
    }
    
    .cover-image-preview img {
        max-height: 200px;
        object-fit: contain;
    }
    
    /* Form field focus effects */
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    /* SEO preview */
    .seo-preview {
        transition: all 0.3s ease;
    }
    
    /* Image gallery card hover effect */
    #existing-images-gallery .card {
        transition: all 0.2s ease;
    }
    
    #existing-images-gallery .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ============================================================
    // 1. IMPROVED IMAGE UPLOADER WITH PREVIEW
    // ============================================================
    const imagePreview = (input, previewSelector) => {
        input.addEventListener('change', () => {
            const preview = document.querySelector(previewSelector);
            
            // Clear previous preview
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'preview-img');
                    img.alt = 'Image preview';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                // Show placeholder if no file selected
                const placeholder = document.createElement('div');
                placeholder.classList.add('placeholder-img', 'd-flex', 'align-items-center', 'justify-content-center', 'h-100');
                placeholder.innerHTML = '<i class="fas fa-image fa-3x text-muted"></i>';
                preview.appendChild(placeholder);
            }
        });
    };
    
    // Initialize cover image preview
    const coverInput = document.getElementById('coverImage');
    if (coverInput) {
        imagePreview(coverInput, '.cover-image-preview');
    }
    
    // ============================================================
    // 2. ENHANCED GALLERY IMAGES REPEATER
    // ============================================================
    const imageContainer = document.getElementById('new-image-container');
    const addImgBtn = document.getElementById('add-img');
    
    // More modern and user-friendly image entry template
    const imageEntryTemplate = () => {
        const id = Date.now(); // Unique ID for the form elements
        return `
        <div class="col-md-6 col-lg-4 new-img-entry">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="position-relative mb-3">
                        <div class="image-preview rounded border bg-light text-center p-2 mb-2" style="height: 140px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                        <input type="file" 
                               name="service_images[]"
                               id="new-img-${id}" 
                               class="form-control mb-2"
                               accept="image/*" 
                               required>
                    </div>
                    
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fas fa-font"></i></span>
                        <input type="text" 
                               name="image_alt_text_en[]" 
                               class="form-control"
                               placeholder="Alt text (EN)">
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-font"></i></span>
                        <input type="text" 
                               name="image_alt_text_ar[]" 
                               class="form-control"
                               placeholder="Alt (AR)" 
                               dir="rtl">
                    </div>
                </div>
                <div class="card-footer bg-light p-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-new-img">
                        <i class="fas fa-trash-alt me-1"></i> Remove
                    </button>
                </div>
            </div>
        </div>`;
    };
    
    if (addImgBtn) {
        // Add new image entry and set up preview
        addImgBtn.addEventListener('click', () => {
            const newEntry = document.createElement('div');
            newEntry.innerHTML = imageEntryTemplate();
            
            // Append to container
            const entry = newEntry.firstElementChild;
            imageContainer.appendChild(entry);
            
            // Set up preview for this entry
            const inputId = entry.querySelector('input[type="file"]').id;
            const previewContainer = entry.querySelector('.image-preview');
            
            // Initialize preview functionality
            entry.querySelector('input[type="file"]').addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewContainer.innerHTML = '';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxHeight = '140px';
                        img.style.maxWidth = '100%';
                        img.style.objectFit = 'contain';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
        
        // Add initial entry if there are no existing images
        const existingImagesGallery = document.getElementById('existing-images-gallery');
        if (!existingImagesGallery || existingImagesGallery.children.length === 0) {
            addImgBtn.click();
        }
    }
    
    // Remove new image entry
    if (imageContainer) {
        imageContainer.addEventListener('click', e => {
            if (e.target.closest('.remove-new-img')) {
                const entry = e.target.closest('.new-img-entry');
                // Smooth remove with animation
                entry.style.transition = 'all 0.3s ease';
                entry.style.opacity = '0';
                entry.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    entry.remove();
                }, 300);
            }
        });
    }
    
    // Handle removing existing images
    document.body.addEventListener('click', e => {
        if (e.target.closest('.remove-existing-img')) {
            const card = e.target.closest('.col-md-4, .col-lg-3');
            const row = e.target.closest('.row');
            const idVal = card.querySelector('input[name="existing_image_ids[]"]').value;
            
            // Add hidden input to mark for deletion
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_images[]';
            hiddenInput.value = idVal;
            document.querySelector('form').appendChild(hiddenInput);
            
            // Visual feedback with animation
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                card.remove();
                // Update image counter if needed
                const counter = document.querySelector('#gallery-tab .badge');
                if (counter) {
                    counter.textContent = row.children.length;
                }
            }, 300);
        }
    });
    
    // ============================================================
    // 3. SLUG GENERATOR AND AUTO-COMPLETE
    // ============================================================
    const slugField = document.getElementById('slug-field');
    const generateSlugBtn = document.getElementById('generate-slug');
    const titleEnField = document.querySelector('input[name="title_en"]');
    
    if (generateSlugBtn && titleEnField && slugField) {
        // Function to generate slug from text
        const generateSlug = (text) => {
            return text.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        };
        
        // Generate slug on button click
        generateSlugBtn.addEventListener('click', () => {
            if (titleEnField.value) {
                slugField.value = generateSlug(titleEnField.value);
                // Visual feedback animation
                slugField.classList.add('is-valid');
                setTimeout(() => {
                    slugField.classList.remove('is-valid');
                }, 2000);
            }
        });
        
        // Optionally auto-generate slug if field is empty and title changes
        titleEnField.addEventListener('blur', () => {
            if (!slugField.value && titleEnField.value) {
                slugField.value = generateSlug(titleEnField.value);
            }
        });
    }
    
    // ============================================================
    // 4. SEO METADATA HELPERS & LIVE PREVIEW
    // ============================================================
    const updateCharCounter = (field, counter, maxLimit) => {
        const count = field.value.length;
        const counterEl = document.getElementById(counter);
        
        if (counterEl) {
            counterEl.textContent = `${count}/${maxLimit}`;
            
            // Visual feedback for length
            if (count > maxLimit) {
                counterEl.classList.add('text-danger');
                counterEl.classList.remove('text-success', 'text-muted');
            } else if (count > 0) {
                counterEl.classList.add('text-success');
                counterEl.classList.remove('text-danger', 'text-muted');
            } else {
                counterEl.classList.add('text-muted');
                counterEl.classList.remove('text-success', 'text-danger');
            }
        }
    };
    
    // Initialize SEO character counters
    const seoFields = [
        { id: 'meta-title-en', counter: 'meta-title-en-counter', max: 60 },
        { id: 'meta-title-ar', counter: 'meta-title-ar-counter', max: 60 },
        { id: 'meta-desc-en', counter: 'meta-desc-en-counter', max: 160 },
        { id: 'meta-desc-ar', counter: 'meta-desc-ar-counter', max: 160 }
    ];
    
    seoFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            // Initial count update
            updateCharCounter(element, field.counter, field.max);
            
            // Update counter on input
            element.addEventListener('input', () => {
                updateCharCounter(element, field.counter, field.max);
                
                // Update preview if English fields change
                if (field.id === 'meta-title-en') {
                    const preview = document.getElementById('seo-preview-title');
                    if (preview) {
                        preview.textContent = element.value || titleEnField.value || 'Service Title Preview';
                    }
                } else if (field.id === 'meta-desc-en') {
                    const preview = document.getElementById('seo-preview-desc');
                    if (preview) {
                        preview.textContent = element.value || 'Your meta description will appear here...';
                    }
                }
            });
        }
    });
    
    // Update SEO preview slug
    if (slugField) {
        slugField.addEventListener('input', () => {
            const slugPreview = document.querySelector('.seo-preview .text-success');
            if (slugPreview) {
                slugPreview.textContent = `www.yourwebsite.com/services/${slugField.value || 'service-slug'}`;
            }
        });
    }
    
    // ============================================================
    // 5. FORM VALIDATION AND TAB NAVIGATION
    // ============================================================
    const form = document.getElementById('serviceForm');
    const tabLinks = document.querySelectorAll('#serviceTabs .nav-link');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Check for required fields
            const requiredFields = form.querySelectorAll('[required]');
            let hasErrors = false;
            let firstErrorTab = null;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    // Visual feedback for errors
                    field.classList.add('is-invalid');
                    hasErrors = true;
                    
                    // Find the tab containing this field
                    const tabPane = field.closest('.tab-pane');
                    if (tabPane && !firstErrorTab) {
                        firstErrorTab = tabPane.id;
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Focus on the first tab with errors
            if (hasErrors && firstErrorTab) {
                e.preventDefault();
                const tabToActivate = document.querySelector(`[data-bs-target="#${firstErrorTab}"]`);
                if (tabToActivate) {
                    // Activate the tab with the error
                    const tabInstance = new bootstrap.Tab(tabToActivate);
                    tabInstance.show();
                    
                    // Scroll to first error field
                    const firstErrorField = document.querySelector(`#${firstErrorTab} .is-invalid`);
                    if (firstErrorField) {
                        setTimeout(() => {
                            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstErrorField.focus();
                        }, 200);
                    }
                }
            }
        });
        
        // Remove validation styling on input
        form.addEventListener('input', function(e) {
            if (e.target.classList.contains('is-invalid') && e.target.value.trim()) {
                e.target.classList.remove('is-invalid');
            }
        });
    }
    
    // Add visual indicator to tabs with errors
    const checkTabsForErrors = () => {
        tabLinks.forEach(tab => {
            const target = tab.getAttribute('data-bs-target');
            const tabPane = document.querySelector(target);
            
            if (tabPane) {
                const hasErrors = tabPane.querySelectorAll('.is-invalid').length > 0;
                
                // Add/remove error indicator on tab
                if (hasErrors) {
                    if (!tab.querySelector('.text-danger')) {
                        const icon = document.createElement('i');
                        icon.className = 'fas fa-exclamation-circle ms-1 text-danger';
                        tab.appendChild(icon);
                    }
                } else {
                    const icon = tab.querySelector('.text-danger');
                    if (icon) icon.remove();
                }
            }
        });
    };
    
    // Check for errors on page load
    checkTabsForErrors();
    
    // Store active tab in local storage for preserving state on page refresh
    tabLinks.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('activeServiceTab', e.target.id);
        });
    });
    
    // Restore active tab from local storage
    const activeTab = localStorage.getItem('activeServiceTab');
    if (activeTab) {
        const tabToActivate = document.getElementById(activeTab);
        if (tabToActivate) {
            const tabInstance = new bootstrap.Tab(tabToActivate);
            tabInstance.show();
        }
    }
    
    // ============================================================
    // 6. SMOOTH INTERACTIONS AND TRANSITIONS
    // ============================================================
    
    // Smooth scroll to top on tab change
    tabLinks.forEach(tab => {
        tab.addEventListener('click', function () {
            setTimeout(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 50);
        });
    });
    
    // Highlight active language tab
    const languageTabs = document.querySelectorAll('[data-bs-toggle="tab"]');
    languageTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            // Add subtle pulse animation to active tab content
            const target = document.querySelector(this.dataset.bsTarget);
            if (target) {
                target.style.animation = 'pulse 0.3s';
                setTimeout(() => {
                    target.style.animation = '';
                }, 300);
            }
        });
    });
});
</script>
@endpush