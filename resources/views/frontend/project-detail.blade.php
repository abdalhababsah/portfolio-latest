@extends('frontend.layout.base')


@section('content')
    <style>
/* ===== Enhanced Gallery Section ===== */
.single-gal-boxes {
  margin-bottom: -1.875rem;
}

/* Main gallery grid */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(min(100%, 400px), 1fr));
  grid-auto-rows: 300px;
  grid-gap: 1.25rem;
}

/* For larger screens - more refined grid */
@media (min-width: 992px) {
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: 320px;
  }
  
  /* Make every third image span 2 rows for visual interest */
  .gallery-grid .single-gal-box:nth-child(3n+1) {
    grid-row: span 1;
  }
}

.single-gal-box {
  position: relative;
  overflow: hidden;
  border-radius: var(--round15);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
  height: 100%;
  width: 100%;
}

.single-gal-box:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

/* Image wrapper to maintain aspect ratio and centering */
.single-gal-box a {
  display: block;
  height: 100%;
  width: 100%;
  position: relative;
}

.single-gal-box img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* This ensures all images cover their container uniformly */
  transition: transform 0.6s cubic-bezier(0.19, 0.68, 0.49, 1.21);
}

.single-gal-box:hover img {
  transform: scale(1.05);
}

/* Image overlay effects */
.single-gal-box::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 60%);
  opacity: 0;
  transition: opacity 0.4s ease;
  pointer-events: none;
}

.single-gal-box:hover::after {
  opacity: 1;
}

/* Image caption overlay */
.single-gal-box .img-caption {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1rem;
  background: rgba(0, 0, 0, 0.5);
  color: white;
  font-size: 0.95rem;
  transform: translateY(100%);
  transition: transform 0.3s ease;
  backdrop-filter: blur(5px);
  opacity: 0;
}

.single-gal-box:hover .img-caption {
  transform: translateY(0);
  opacity: 1;
}

/* Zoom indicator icon */
.single-gal-box::before {
  content: "\f00e"; /* fa-search-plus */
  font-family: "Font Awesome 5 Pro";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0);
  width: 60px;
  height: 60px;
  background-color: var(--scheme1);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  opacity: 0;
  transition: opacity 0.3s ease, transform 0.3s ease;
  z-index: 2;
  pointer-events: none;
}

.single-gal-box:hover::before {
  transform: translate(-50%, -50%) scale(1);
  opacity: 0.9;
}

/* Light mode adjustments */
.light .single-gal-box {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
}

.light .single-gal-box:hover {
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}

.light .single-gal-box::after {
  background: linear-gradient(to top, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0) 60%);
}

/* ===== Enhanced Video Section ===== */
.project-videos {
  margin-bottom: -1.875rem;
}

.project-videos h3 {
  position: relative;
  padding-bottom: 1rem;
  margin-bottom: 2rem;
}

.project-videos h3::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background-color: var(--scheme1);
}

.video-container {
  position: relative;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  overflow: hidden;
  border-radius: var(--round15);
  margin-bottom: 1.875rem;
}

/* Specific styles for single video case */
.single-video-container {
  max-width: 900px;
  margin-left: auto;
  margin-right: auto;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.video-container:hover {
  transform: translateY(-8px);
}

.video-container::before {
  content: "";
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(to right, var(--scheme1), transparent);
}

/* Enhanced decoration for single video */
.single-video-container::after {
  content: "";
  position: absolute;
  z-index: -1;
  bottom: -10px;
  left: 20px;
  right: 20px;
  height: 10px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
  filter: blur(10px);
}

/* Fix for video display */
.video-container .ratio {
  width: 100%;
  height: 0;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
  position: relative;
  display: block;
  border-radius: var(--round10) var(--round10) 0 0;
  overflow: hidden;
}

.video-container .ratio video,
.video-container .ratio iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: var(--round10) var(--round10) 0 0;
  transition: transform 0.6s ease;
}

.video-container:hover .ratio video,
.video-container:hover .ratio iframe {
  transform: scale(1.02);
}

/* Video thumbnail gradient overlay */
.video-container .ratio::before {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at center, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.3) 100%);
  z-index: 1;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.4s ease;
}

.video-container:hover .ratio::before {
  opacity: 1;
}

/* Caption styling */
.video-container p {
  position: relative;
  margin: 0;
  padding: 0.75rem 1rem;
  color: var(--color3);
  font-family: var(--Lato);
  font-size: 0.95rem;
  font-style: italic;
  transition: color 0.3s ease;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 0 0 var(--round10) var(--round10);
  background-color: rgba(37, 37, 37, 0.5);
  backdrop-filter: blur(5px);
}

.single-video-container p {
  text-align: center;
  font-size: 1.05rem;
  padding: 1rem;
}

.video-container:hover p {
  color: var(--scheme1);
}

/* Light mode adjustments */
.light .video-container {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.light .single-video-container {
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.light .video-container p {
  color: var(--color7);
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  background-color: rgba(240, 240, 240, 0.5);
}

.light .video-container:hover p {
  color: var(--scheme1);
}

.light .video-container::before {
  background: linear-gradient(to right, var(--scheme1), rgba(255, 255, 255, 0));
}

.light .single-video-container::after {
  background-color: rgba(0, 0, 0, 0.05);
}

/* Video controls styling enhancement */
.video-container video::-webkit-media-controls-panel {
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.5));
}

.video-container video::-webkit-media-controls-play-button {
  background-color: var(--scheme1);
  border-radius: 50%;
  color: white;
}

/* ===== Shared Responsive Styles ===== */
@media (max-width: 991.98px) {
  .project-videos .row > div {
    margin-bottom: 1.5rem;
  }
  
  .video-container::before {
    height: 2px;
  }
  
  .gallery-grid {
    grid-auto-rows: 280px;
  }
  
  .single-video-container {
    max-width: 700px;
  }
}

@media (max-width: 767.98px) {
  .single-gal-box,
  .video-container {
    margin-bottom: 1.25rem;
  }
  
  .project-videos h3,
  .single-gal-boxes h3 {
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
  }
  
  .video-container p {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
  }
  
  .single-video-container p {
    font-size: 0.95rem;
    padding: 0.75rem;
  }
  
  .gallery-grid {
    grid-auto-rows: 250px;
    grid-gap: 1rem;
  }
  
  .single-gal-box .img-caption {
    padding: 0.75rem;
    font-size: 0.875rem;
  }
  
  .single-gal-box::before {
    width: 50px;
    height: 50px;
    font-size: 1rem;
  }
  
  .single-video-container {
    max-width: 100%;
  }
}

/* ===== RTL Support ===== */
html[dir="rtl"] .project-videos h3::after,
html[dir="rtl"] .single-gal-boxes h3::after {
  left: auto;
  right: 0;
}

html[dir="rtl"] .video-container::before {
  background: linear-gradient(to left, var(--scheme1), transparent);
}
    </style>

    <section>
        <div class="w-100 pt-60 pb-130 position-relative">
            <div class="container">
                <div class="resume-wrapper d-flex justify-content-between position-relative w-100">
                    @include('frontend.common.sticky-user-card')
                    <div class="resume-content d-flex flex-column">
                        <div class="theiaStickySidebar">
                            <section>
                                <div class="position-relative w-100">
                                    <div
                                        class="page-title gap-3 d-flex align-items-center justify-content-between round15 w-100">
                                        <h3 class="mb-0 fw-normal sz-36">{{ $project->title }}</h3>
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                                    title="">{{ __('Home') }}</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}"
                                                    title="">{{ __('Projects') }}</a></li>
                                            <li class="breadcrumb-item active">{{ Str::limit($project->title, 20) }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="position-relative pt-60 w-100">
                                    <div class="port-detail position-relative w-100">
                                        <div class="port-detail-img round15 overflow-hidden position-relative w-100">
                                            <img class="img-fluid w-100"
                                                src="{{ asset('storage/' . $project->cover_image) }}"
                                                alt="{{ $project->title }}" loading="lazy">
                                            <div class="port-cat d-flex align-items-center position-absolute">
                                                @if ($project->category)
                                                    <a href="" title="">{{ $project->category->name }}</a>
                                                @endif
                                                @foreach ($project->technologies as $tech)
                                                    <a href="" title="">{{ $tech->name }}</a>
                                                @endforeach
                                            </div><!-- Portfolio Categories -->
                                        </div><!-- Portfolio Detail Image -->
                                        <div class="port-detail-cont mt-50 d-flex flex-column position-relative w-100">
                                            <div class="port-detail-cont-box position-relative w-100">
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-12 col-lg-5">
                                                        <div
                                                            class="port-detail-cap d-flex flex-column align-items-start w-100">
                                                            <h3 class="mb-0 fw-normal sz-36">{{ $project->title }}</h3>
                                                            <span>{{ $project->role ?? __('Designing') }}</span>
                                                            <div
                                                                class="single-social-wrap d-flex align-items-center position-relative w-100">
                                                                <span>{{ __('Share:') }}</span>
                                                                <div class="social-links2 d-flex align-items-center gap-1">
                                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                                        title="Facebook" target="_blank"><i
                                                                            class="fab fa-facebook-f"></i></a>
                                                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $project->title }}"
                                                                        title="Twitter" target="_blank"><i
                                                                            class="fab fa-twitter"></i></a>
                                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $project->title }}"
                                                                        title="Linkedin" target="_blank"><i
                                                                            class="fab fa-linkedin-in"></i></a>
                                                                    <a href="https://www.instagram.com/" title="Instagram"
                                                                        target="_blank"><i class="fab fa-instagram"></i></a>
                                                                </div><!-- Social Links -->
                                                            </div><!-- Single Social Wrap -->
                                                        </div><!-- Portfolio Detail Cap -->
                                                    </div>
                                                    <div class="col-md-7 col-sm-12 col-lg-7">
                                                        <p class="mb-0">{!! $project->full_description !!}</p>
                                                    </div>
                                                </div>
                                            </div><!-- Portfolio Detail Content Box -->
                                            <div class="port-detail-info-boxes round15 position-relative w-100">
                                                <div class="row mrg">
                                                    <div class="col-md-6 col-sm-6 col-lg-3">
                                                        <div
                                                            class="port-detail-info-box d-flex flex-column overflow-hidden position-relative w-100">
                                                            <strong>{{ __('Category:') }}</strong>
                                                            <h4 class="mb-0 fw-normal sz-24">
                                                                {{ $project->category->name ?? __('N/A') }}</h4>
                                                        </div><!-- Portfolio Detail Info Box -->
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-lg-3">
                                                        <div
                                                            class="port-detail-info-box d-flex flex-column overflow-hidden position-relative w-100">
                                                            <strong>{{ __('Role:') }}</strong>
                                                            <h4 class="mb-0 fw-normal sz-24">
                                                                {{ $project->role ?? __('N/A') }}
                                                            </h4>
                                                        </div><!-- Portfolio Detail Info Box -->
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-lg-3">
                                                        <div
                                                            class="port-detail-info-box d-flex flex-column overflow-hidden position-relative w-100">
                                                            <strong>{{ __('Duration:') }}</strong>
                                                            <h4 class="mb-0 fw-normal sz-24">
                                                                {{ $project->duration ?? __('N/A') }}</h4>
                                                        </div><!-- Portfolio Detail Info Box -->
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-lg-3">
                                                        <div
                                                            class="port-detail-info-box d-flex flex-column overflow-hidden position-relative w-100">
                                                            <strong>{{ __('Tags:') }}</strong>
                                                            <h4 class="mb-0 fw-normal sz-24">
                                                                @forelse($project->tags as $tag)
                                                                    {{ $tag->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @empty
                                                                    {{ __('N/A') }}
                                                                @endforelse
                                                            </h4>
                                                        </div><!-- Portfolio Detail Info Box -->
                                                    </div>
                                                </div>
                                            </div><!-- Portfolio Detail Info Boxes -->

                                            <!-- Project Links Section -->

                                            @if ($project->github_url || $project->demo_url)
                                                <div class="port-detail-links position-relative w-100 mt-4">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-flex gap-3">
                                                                @if ($project->github_url)
                                                                    <a href="{{ $project->github_url }}" target="_blank"
                                                                        class="theme-btn3 github-btn">
                                                                        <i class="fab fa-github"></i>{{ __('View Code') }}
                                                                    </a>
                                                                @endif
                                                                @if ($project->demo_url)
                                                                    <a href="{{ $project->demo_url }}" target="_blank"
                                                                        class="theme-btn3 demo-btn">
                                                                        <i
                                                                            class="fas fa-external-link-alt"></i>{{ __('Live Demo') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Technologies Detail -->
                                            @if (count($project->technologies) > 0)
                                                <div class="port-detail-cont-box position-relative w-100 mt-5">
                                                    <div class="row">
                                                        <div class="col-md-5 col-sm-12 col-lg-5">
                                                            <h3 class="mb-0 fw-normal sz-36">{{ __('Technologies Used') }}
                                                            </h3>
                                                        </div>
                                                        <div class="col-md-7 col-sm-12 col-lg-7">
                                                            <div class="tech-tags d-flex flex-wrap gap-2">
                                                                @foreach ($project->technologies as $tech)
                                                                    <span
                                                                        class="badge bg-light text-dark p-2">{{ $tech->name }}</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Gallery Images Section --}}
                                            {{-- Gallery Images Section - Uniform Grid Layout --}}
                                            @if (count($project->images) > 0)
                                                <div class="single-gal-boxes position-relative w-100 mt-5">
                                                    <h3 class="mb-4 fw-normal sz-36">{{ __('Project Gallery') }}</h3>

                                                    <div class="gallery-grid">
                                                        @foreach ($project->images->where('is_main', false) as $image)
                                                            <div class="single-gal-box overflow-hidden position-relative wow fadeIn"
                                                                data-wow-duration=".5s"
                                                                data-wow-delay=".{{ $loop->iteration * 2 }}s">
                                                                <a href="{{ asset('storage/' . $image->image_path) }}"
                                                                    data-fancybox="gallery" title="{{ $image->alt_text }}">
                                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                        alt="{{ $image->alt_text }}" loading="lazy">
                                                                    @if ($image->alt_text)
                                                                        <div class="img-caption">{{ $image->alt_text }}
                                                                        </div>
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                         {{-- Videos Section with Single Video Support --}}
@if ($project->videos->isNotEmpty())
<div class="project-videos position-relative w-100 mt-5">
    <h3 class="mb-4 fw-normal sz-36">{{ __('Project Videos') }}</h3>

    @if ($project->videos->count() == 1)
        {{-- Single video layout --}}
        @php
            $video = $project->videos->first();
            $isRemote = str_contains($video->video_url, 'http') && !str_contains($video->video_url, 'storage');
            $display = $isRemote
                ? str_replace(
                    'watch?v=',
                    'embed/',
                    $video->video_url,
                ) // YT -> embed
                : asset('storage/' . $video->video_url); // local path
        @endphp
        
        <div class="video-container single-video-container round15 overflow-hidden position-relative w-100">
            <div class="ratio">
                @if ($isRemote)
                    <iframe src="{{ $display }}"
                        title="{{ $video->caption }}"
                        allowfullscreen></iframe>
                @else
                    <video src="{{ $display }}" controls></video>
                @endif
            </div>

            @if ($video->caption)
                <p class="mt-0">{{ $video->caption }}</p>
            @endif
        </div>
    @else
        {{-- Multiple videos layout --}}
        <div class="row mrg20">
            @foreach ($project->videos as $video)
                @php
                    $isRemote = str_contains($video->video_url, 'http') && !str_contains($video->video_url, 'storage');
                    $display = $isRemote
                        ? str_replace(
                            'watch?v=',
                            'embed/',
                            $video->video_url,
                        ) // YT -> embed
                        : asset('storage/' . $video->video_url); // local path
                @endphp

                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="video-container round15 overflow-hidden position-relative w-100">
                        <div class="ratio">
                            @if ($isRemote)
                                <iframe src="{{ $display }}"
                                    title="{{ $video->caption }}"
                                    allowfullscreen></iframe>
                            @else
                                <video src="{{ $display }}" controls></video>
                            @endif
                        </div>

                        @if ($video->caption)
                            <p class="mt-0">{{ $video->caption }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endif

                                            <!-- Navigation Between Projects -->
                                            <div
                                                class="projects-navigation d-flex justify-content-between mt-5 pt-4 border-top">
                                                <div class="prev-project">
                                                    @if ($previous)
                                                        <a href="{{ route('projects.show', $previous->slug) }}"
                                                            class="d-flex align-items-center">
                                                            <i
                                                                class="fas {{ app()->getLocale() == 'ar' ? 'fa-arrow-right ms-2' : 'fa-arrow-left me-2' }}"></i>
                                                            <div>
                                                                <small>{{ __('Previous Project') }}</small>
                                                                <h5 class="mb-0">{{ Str::limit($previous->title, 20) }}
                                                                </h5>
                                                            </div>
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="next-project text-end">
                                                    @if ($next)
                                                        <a href="{{ route('projects.show', $next->slug) }}"
                                                            class="d-flex align-items-center justify-content-end">
                                                            <div>
                                                                <small>{{ __('Next Project') }}</small>
                                                                <h5 class="mb-0">{{ Str::limit($next->title, 20) }}</h5>
                                                            </div>
                                                            <i
                                                                class="fas {{ app()->getLocale() == 'ar' ? 'fa-arrow-left ms-2' : 'fa-arrow-right me-2' }}"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                        </div><!-- Portfolio Detail Content -->
                                    </div><!-- Portfolio Detail -->
                                </div>
                            </section>

                            @include('frontend.common.contact-form')

                        </div>
                    </div><!-- Resume Content -->
                </div><!-- Resume Wrapper -->
            </div>
        </div>
    </section>
@endsection
