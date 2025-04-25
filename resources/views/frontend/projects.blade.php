@php($locale = app()->getLocale()) {{-- just in case you need it elsewhere --}}
@extends('frontend.layout.base')

@section('content')
<section>
    <div class="w-100 pt-60 pb-130 position-relative">
        <div class="container">
            <div class="resume-wrapper d-flex justify-content-between position-relative w-100">

                {{-- ─────── Sidebar (unchanged) ─────── --}}
                @include('frontend.common.sticky-user-card')

                {{-- ──────────────────────────────── --}}

                <div class="resume-content d-flex flex-column">
                    <div class="theiaStickySidebar">

                        {{-- ---------- Page Title ---------- --}}
                        <section>
                            <div class="position-relative w-100">
                                <div class="page-title gap-3 d-flex align-items-center justify-content-between round15 w-100">
                                    <h3 class="mb-0 fw-normal sz-36">{{ __('My Recent Projects') }}</h3>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('Portfolio') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </section>

                        {{-- ---------- Projects Grid ---------- --}}
                        <section>
                            <div class="position-relative pt-60 w-100">
                                <div class="port-boxes position-relative w-100">
                                    <div class="row mrg20">

                                        @foreach ($projects as $project)
                                            <div class="col-md-6 col-sm-6 col-lg-4 wow fadeIn"
                                                 data-wow-duration=".8s"
                                                 data-wow-delay=".{{ $loop->iteration }}s">

                                                <div class="port-box d-flex flex-column align-items-start w-100">

                                                    {{-- Cover image --}}
                                                    <div class="port-img round15 overflow-hidden position-relative w-100">
                                                        <a href="{{ route('projects.show', $project->slug) }}">
                                                            <img class="img-fluid w-100"
                                                                 src="{{ asset('storage/'. $project->cover_image) }}"
                                                                 alt="{{ $project->title }}"
                                                                 loading="lazy">
                                                        </a>

                                                        {{-- Technology tags (first two shown) --}}
                                                        @if ($project->technologies->isNotEmpty())
                                                            <div class="port-cat d-flex align-items-center position-absolute">
                                                                @foreach ($project->technologies->take(2) as $tech)
                                                                    <a href="javascript:void(0);">{{ $tech->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>

                                                    {{-- Title + category --}}
                                                    <div class="port-info d-flex flex-column align-items-start w-100">
                                                        <a class="port-read rounded-circle"
                                                           href="{{ route('projects.show', $project->slug) }}">
                                                           <i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i>
                                                        </a>

                                                        <h4 class="mb-0 fw-normal sz-26">
                                                            <a href="{{ route('projects.show', $project->slug) }}">
                                                                {{ $project->title }}
                                                            </a>
                                                        </h4>

                                                        <span>{{ optional($project->category)->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- ---------- Pagination ---------- --}}
                                <div class="mt-70 d-block w-100 text-center">
                                    {{ $projects->links() }}
                                </div>
                            </div>
                        </section>

                        {{-- ---------- Contact section (your existing include) ---------- --}}
                        @include('frontend.common.contact-form')

                    </div>
                </div> {{-- resume-content --}}
            </div>  {{-- resume-wrapper --}}
        </div>
    </div>
</section>
@endsection