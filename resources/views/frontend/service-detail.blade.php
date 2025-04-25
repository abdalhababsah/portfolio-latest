@extends('frontend.layout.base')

@section('meta')
<meta name="description" content="{{ $service->meta_description ?? $service->description }}">
<meta name="keywords" content="{{ $service->meta_keywords ?? '' }}">
<title>{{ $service->meta_title ?? $service->title }} | {{ config('app.name') }}</title>
@endsection

@section('content')
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
                                    <h3 class="mb-0 fw-normal sz-36">{{ $service->title }}</h3>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">{{ __('Home') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('services.index') }}" title="">{{ __('Services') }}</a></li>
                                        <li class="breadcrumb-item active">{{ Str::limit($service->title, 20) }}</li>
                                    </ol>
                                </div><!-- Page Title -->
                            </div>
                        </section>
                        <section>
                            <div class="position-relative pt-60 w-100">
                                <div class="serv-detail position-relative w-100">
                                    <div class="serv-detail-img round15 overflow-hidden position-relative w-100">
                                        <img class="img-fluid w-100" src="{{ asset('storage/' . $service->cover_image) }}"
                                            alt="{{ $service->title }}" loading="lazy">
                                    </div><!-- Service Detail Image -->
                                    <div class="serv-detail-cont mt-50 position-relative w-100">
                                        <div class="serv-detail-cap position-relative w-100">
                                            <span>
                                                {{ $service->price }} {{ $service->currency }} 
                                                @if($service->unit)
                                                / {{ $service->unit }}
                                                @endif
                                            </span>
                                            <h3 class="mb-0 fw-normal sz-36">{{ $service->title }} <strong>{{ $service->images_count ?? 0 }} {{ __('Projects') }}</strong></h3>
                                            <div class="service-description">
                                                {!! $service->description !!}
                                            </div>
                                        </div><!-- Service Detail Cap -->
                                        
                                        <!-- Call Action Box -->
                                        <div class="call-action-box round15 d-flex align-items-center justify-content-between gap-3 position-relative w-100">
                                            <div class="sec-title d-flex flex-column align-items-start">
                                                <h2 class="mb-0 sz-30">{{ __("Let's Work Together") }}</h2>
                                                <p class="mb-0">{{ __("Let's start to capture the wonderful moments of your life.") }}</p>
                                            </div><!-- Sec Title -->
                                            <div class="cont-info d-inline-flex align-items-center gap-2">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                                        <g>
                                                            <path d="M98.5,53.93c-0.37,3-0.79,5.99-1.64,8.91C93.2,75.48,85.74,85.18,74.43,91.91c-5.85,3.48-12.2,5.63-18.97,6.3
                                                                c-14.05,1.4-26.56-2.41-37.25-11.67C9.19,78.72,3.68,68.81,2.03,56.98c-2.04-14.6,1.77-27.66,11.43-38.84
                                                                c7.82-9.07,17.8-14.4,29.63-16.25c0.93-0.15,1.87-0.25,2.8-0.38c2.78,0,5.55,0,8.33,0c0.15,0.04,0.3,0.1,0.45,0.12
                                                                c7.01,0.65,13.57,2.73,19.63,6.3c11.38,6.72,18.9,16.45,22.57,29.15c0.84,2.91,1.26,5.9,1.63,8.9C98.5,48.64,98.5,51.28,98.5,53.93
                                                                z M6.21,49.96c0.21,24.3,19.48,43.76,43.79,43.79c24.37,0.03,43.84-19.48,43.84-43.79c0-24.29-19.42-43.76-43.75-43.79
                                                                C25.81,6.15,6.43,25.56,6.21,49.96z" />
                                                            <path d="M64.78,78.37c-3.59-0.09-6.96-1.06-10.19-2.57c-7.79-3.63-14.25-9.02-20.02-15.29c-4.66-5.06-8.67-10.6-11.19-17.07
                                                                c-1.42-3.65-2.31-7.42-1.39-11.37c0.8-3.43,2.61-6.09,5.95-7.58c1.99-0.89,3.98-1.76,6.01-2.52c2.83-1.07,5.72-0.1,7.3,2.52
                                                                c1.79,2.97,3.53,5.97,5.2,9.01c1.62,2.93,0.76,6.16-2.02,8.05c-0.21,0.14-0.42,0.27-0.63,0.42c-1.87,1.38-2.17,3.35-0.74,5.18
                                                                c2.86,3.68,6.14,6.94,9.81,9.8c1.01,0.78,2.13,1.07,3.37,0.65c0.85-0.29,1.42-0.92,1.91-1.63c2.44-3.51,5.44-4.17,9.13-2.01
                                                                c2.58,1.51,5.18,3,7.78,4.49c3.07,1.76,4.11,4.7,2.8,7.98c-0.79,1.99-1.6,3.97-2.53,5.91c-1.7,3.56-4.72,5.18-8.41,5.84
                                                                c-0.46,0.08-0.94,0.12-1.41,0.16C65.29,78.39,65.04,78.37,64.78,78.37z M64.68,73.56c0.35,0,0.7,0.03,1.04-0.01
                                                                c2.49-0.29,4.57-1.18,5.59-3.7c0.7-1.72,1.45-3.42,2.15-5.15c0.43-1.06,0.25-1.54-0.74-2.12c-2.67-1.55-5.35-3.09-8.03-4.63
                                                                c-1.22-0.7-1.72-0.57-2.52,0.6c-3.11,4.55-8.21,5.32-12.54,1.89c-3.72-2.95-6.99-6.34-10.03-9.99c-3.31-3.96-2.79-9.73,1.95-12.68
                                                                c1.04-0.64,1.18-1.26,0.59-2.3c-1.56-2.74-3.14-5.47-4.73-8.19c-0.56-0.96-1.04-1.14-2.04-0.75c-1.7,0.67-3.37,1.42-5.07,2.1
                                                                c-2.71,1.08-3.7,3.27-3.85,5.97c-0.2,3.58,0.97,6.87,2.61,9.95c6,11.26,14.68,19.94,25.83,26.12
                                                                C57.91,72.34,61.15,73.51,64.68,73.56z" />
                                                        </g>
                                                    </svg></span>
                                                <div class="cont-info-inner d-flex align-items-start flex-column">
                                                    <span>{{ __('Contact Me At:') }}</span>
                                                    <a href="tel:{{ config('settings.phone_number', '(635) 525-4250') }}" title="Call Us">{{ config('settings.phone_number', '(635) 525-4250') }}</a>
                                                </div><!-- Contact Info Inner -->
                                            </div><!-- Contact Info -->
                                            <div class="btn-box position-relative">
                                                <a class="theme-btn3 github-btn round10 d-flex align-items-center justify-content-center position-relative overflow-hidden"
                                                    href="" title="">{{ __('Contact Me') }}</a>
                                            </div><!-- Btn Box -->
                                        </div><!-- Call Action Box -->
                                        
                                        <!-- Service Gallery -->
                                        @if($service->images->count() > 0)
                                        <div class="serv-detail-cont-box d-inline-block position-relative w-100">
                                            <div class="row align-items-start">
                                                <div class="col-md-5 col-sm-12 col-lg-4 order-md-1">
                                                    <div class="single-gal-box round15 overflow-hidden position-relative w-100">
                                                        @php $mainImage = $service->images->firstWhere('is_main', true) ?? $service->images->first(); @endphp
                                                        <a href="{{ asset('storage/' . $mainImage->image_path) }}"
                                                            data-fancybox="gallery" title="{{ $mainImage->alt_text }}"><img
                                                                class="img-fluid w-100"
                                                                src="{{ asset('storage/' . $mainImage->image_path) }}"
                                                                alt="{{ $mainImage->alt_text }}" loading="lazy"></a>
                                                    </div><!-- Single Gallery Box -->
                                                </div>
                                                <div class="col-md-7 col-sm-12 col-lg-8">
                                                    <h3 class="mb-0 fw-normal sz-36">{{ __('Service Features') }}</h3>
                                                    <p class="mb-0">{{ Str::limit(strip_tags($service->description), 150) }}</p>
                                                    
                                                    @php
                                                        // Extract bullet points from description if any
                                                        $dom = new \DOMDocument();
                                                        @$dom->loadHTML(mb_convert_encoding($service->description, 'HTML-ENTITIES', 'UTF-8'));
                                                        $lists = $dom->getElementsByTagName('ul');
                                                        $listItems = [];
                                                        
                                                        if ($lists->length > 0) {
                                                            $items = $lists->item(0)->getElementsByTagName('li');
                                                            foreach ($items as $item) {
                                                                $listItems[] = $item->textContent;
                                                            }
                                                        }
                                                    @endphp
                                                    
                                                    @if(count($listItems) > 0)
                                                    <ul class="list-style d-flex flex-column mb-0">
                                                        @foreach($listItems as $item)
                                                        <li>{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div><!-- Service Detail Content Box -->
                                        @endif
                                        
                                        <!-- Additional Gallery Images -->
                                        @if($service->images->where('is_main', false)->count() > 0)
                                        <div class="single-gal-boxes position-relative w-100 mt-4">
                                            <h3 class="mb-4 fw-normal sz-30">{{ __('Service Gallery') }}</h3>
                                            <div class="row mrg20">
                                                @foreach($service->images->where('is_main', false) as $image)
                                                <div class="col-md-6 col-sm-6 col-lg-4 wow fadeIn"
                                                    data-wow-duration=".5s" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                                                    <div
                                                        class="single-gal-box round15 overflow-hidden position-relative w-100">
                                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                                            data-fancybox="gallery" title="{{ $image->alt_text }}"><img
                                                                class="img-fluid w-100"
                                                                src="{{ asset('storage/' . $image->image_path) }}"
                                                                alt="{{ $image->alt_text }}" loading="lazy"></a>
                                                    </div><!-- Single Gallery Box -->
                                                </div>
                                                @endforeach
                                            </div>
                                        </div><!-- Single Gallery Boxes -->
                                        @endif
                                        
                                        <!-- Tags and Social Share Section -->
                                        <div class="tags-box-wrap round15 d-flex align-items-center justify-content-between position-relative w-100">
                                            <div class="tags-box d-flex align-items-center position-relative">
                                                <span>{{ __('Tags:') }}</span>
                                                <div class="tagcloud d-flex align-items-center gap-1">
                                                    @if(isset($service->meta_keywords) && $service->meta_keywords)
                                                        @foreach(explode(',', $service->meta_keywords) as $tag)
                                                            <a href="" title="{{ trim($tag) }}">{{ trim($tag) }}</a>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ route('services.index') }}" title="services">{{ __('services') }}</a>
                                                    @endif
                                                </div><!-- Tagcloud -->
                                            </div><!-- Tags Box -->
                                            <div class="single-social-wrap d-flex align-items-center position-relative">
                                                <span>{{ __('Share:') }}</span>
                                                <div class="social-links2 d-flex align-items-center gap-1">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" title="Facebook"
                                                        target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $service->title }}" title="Twitter"
                                                        target="_blank"><i class="fab fa-twitter"></i></a>
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $service->title }}" title="Linkedin"
                                                        target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="https://wa.me/?text={{ $service->title }} {{ url()->current() }}" title="WhatsApp"
                                                        target="_blank"><i class="fab fa-whatsapp"></i></a>
                                                </div><!-- Social Links -->
                                            </div><!-- Single Social Wrap -->
                                        </div><!-- Tags Box Wrap -->
                                        
                                        <!-- Navigation Between Services -->
                                        <div class="single-detail-navs d-flex align-items-center w-100">
                                            @if($previous)
                                            <div class="single-detail-nav-item single-detail-nav-left d-flex flex-column position-relative">
                                                <a href="{{ route('services.show', $previous->slug) }}" title="{{ $previous->title }}">
                                                    <strong>{{ __('Previous') }}</strong>
                                                    {{ Str::limit($previous->title, 30) }}
                                                </a>
                                            </div><!-- Single Detail Nav Item -->
                                            @endif
                                            
                                            @if($next)
                                            <div class="single-detail-nav-item single-detail-nav-right d-flex flex-column position-relative">
                                                <a href="{{ route('services.show', $next->slug) }}" title="{{ $next->title }}">
                                                    <strong>{{ __('Next') }}</strong>
                                                    {{ Str::limit($next->title, 30) }}
                                                </a>
                                            </div><!-- Single Detail Nav Item -->
                                            @endif
                                        </div><!-- Single Detail Navigation -->
                                    </div><!-- Service Detail Content -->
                                </div><!-- Service Detail -->
                            </div>
                        </section>
                        
                        <!-- Related Services Section -->
                        @if($relatedServices->count() > 0)
                        <section>
                            <div class="position-relative pt-70 w-100">
                                <div class="sec-title-wrap mb-50 d-flex flex-column align-items-center position-relative w-100 text-center">
                                    <div class="sec-title d-flex flex-column align-items-center w-100 wow fadeInUp"
                                        data-wow-duration=".5s" data-wow-delay=".2s">
                                        <span class="sec-sub rounded-pill text-center">{{ __('More Services') }}</span>
                                        <h2 class="mb-0 sz-40">{{ __('Related Services') }}</h2>
                                    </div><!-- Sec Title -->
                                </div><!-- Sec Title Wrap -->
                                <div class="serv-boxes position-relative w-100">
                                    <div class="row mrg40">
                                        @foreach($relatedServices as $relatedService)
                                        <div class="col-md-6 col-sm-6 col-lg-4 wow fadeIn"
                                            data-wow-duration=".8s" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                                            <div class="serv-box round15 d-flex flex-column position-relative w-100">
                                                <a class="serv-read rounded-circle" href="{{ route('services.show', $relatedService->slug) }}"
                                                    title="{{ $relatedService->title }}"><i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i></a>
                                                <h3 class="mb-0 fw-normal sz-24"><a href="{{ route('services.show', $relatedService->slug) }}"
                                                        title="{{ $relatedService->title }}">{!! nl2br(e($relatedService->title)) !!}</a></h3>
                                                <p class="mb-0">{{ Str::limit(strip_tags($relatedService->description), 60) }}</p>
                                                <span class="price-tag">
                                                    {{ $relatedService->price }} {{ $relatedService->currency }}
                                                    @if($relatedService->unit)
                                                    / {{ $relatedService->unit }}
                                                    @endif
                                                </span>
                                            </div><!-- Service Box -->
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endif

                        
                        <!-- Service Contact Form Section -->
                        <section id="service-contact">
                            @include('frontend.common.contact-form', ['selected_service' => $service->id])
                        </section>
                    </div>
                </div><!-- Resume Content -->
            </div><!-- Resume Wrapper -->
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scroll to contact form when "Discuss Project" is clicked
    document.addEventListener('DOMContentLoaded', function() {
        const discussBtn = document.querySelector('a[href="#service-contact"]');
        if (discussBtn) {
            discussBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const contactSection = document.getElementById('service-contact');
                contactSection.scrollIntoView({ behavior: 'smooth' });
            });
        }
    });
</script>
@endpush