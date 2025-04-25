@extends('frontend.layout.base')
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
                                    <h3 class="mb-0 fw-normal sz-36">{{ __('My Services') }}</h3>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">{{ __('Home') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('Services') }}</li>
                                    </ol>
                                </div><!-- Page Title -->
                            </div>
                        </section>
                        <section>
                            <div class="position-relative pt-60 w-100">
                                <div class="sec-title-wrap mb-50 d-flex position-relative gap-4 w-100">
                                    <div class="sec-title d-flex flex-column w-100">
                                        <h2 class="mb-0 sz-36">{{ __('My Special Service For You') }}</h2>
                                    </div><!-- Sec Title -->
                                    <p class="mb-0">{{ __('At vero eos et accusamus etodio dignissimos ducimus praesentium voluptatum corrupti quos dolores quas molestias excepturi sint occaecati cupiditate provident qui officia deserunt mollitia animi, id est laborum et dolorum.') }}</p>
                                </div><!-- Sec Title Wrap -->
                                <div class="serv-boxes position-relative w-100">
                                    <div class="row mrg40">
                                        @forelse($services as $service)
                                        <div class="col-md-6 col-sm-6 col-lg-4 wow fadeIn"
                                            data-wow-duration=".8s" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                                            <div
                                                class="serv-box round15 d-flex flex-column position-relative w-100">
                                                <a class="serv-read rounded-circle" href="{{ route('services.show', $service->slug) }}"
                                                    title="{{ $service->title }}"><i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i></a>
                                                <h3 class="mb-0 fw-normal sz-30"><a href="{{ route('services.show', $service->slug) }}"
                                                        title="{{ $service->title }}">{!! nl2br(e($service->title)) !!}</a></h3>
                                                <p class="mb-0">{{ Str::limit(strip_tags($service->description), 60) }}</p>
                                                <span>{{ $service->images_count ?? 0 }} {{ __('Projects') }}</span>
                                            </div><!-- Service Box -->
                                        </div>
                                        @empty
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                {{ __('No services available at the moment. Please check back later.') }}
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div><!-- Service Boxes -->
                                
                                @if($services->hasPages())
                                <div class="pagination-wrap d-flex justify-content-center mt-50 w-100">
                                    {{ $services->links('frontend.common.custom-pagination') }}
                                </div>
                                @endif
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