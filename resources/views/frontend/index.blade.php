@extends('frontend.layout.base')
@section('content')
    <section>
        <div class="w-100 pt-60 pb-130 position-relative">
            <div class="container">
                <div class="resume-wrapper d-flex justify-content-between position-relative w-100">
                    {{-- ================= Sidebar ================= --}}
@include('frontend.common.sticky-user-card')

                    {{-- ================= Main ================= --}}
                    <div class="resume-content d-flex flex-column">
                        <div class="theiaStickySidebar">

                            {{-- ************ INTRO ************ --}}
                            <section>
                                <div class="position-relative w-100">
                                    <div class="intro-wrapper d-flex flex-column align-items-start position-relative w-100">
                                        <div class="intro-box d-flex flex-column align-items-start position-relative w-100">
                                            <span class="sec-sub rounded-pill text-center">{{ __('Introduction') }}</span>
                                            <h2 class="mb-0 fw-normal sz-55">{{ __('Hey! I am') }}
                                                <span>{{ $settings['site_title'] ?? 'Abdelrahman Portfolio' }}</span>,
                                                {{ __('Full-Stack Developer') }}
                                            </h2>
                                            <p class="mb-0">
                                                {{ $settings['hero_tagline'] ?? ($settings['hero_heading'] ?? 'Building Digital Experiences') }}
                                            </p>
                                            <div class="intro-btns d-flex align-items-center w-100">
                                                <a class="theme-btn position-relative overflow-hidden round10"
                                                    href="#contact" title=""><i
                                                        class="far fa-envelope"></i>{{ __('Hire Me Now') }}
                                                </a>
                                                @if (isset($settings['cv_url']))
                                                    <a class="simple-link" href="{{ $settings['cv_url'] }}" title=""
                                                        download><i
                                                            class="fas fa-arrow-alt-to-bottom round5"></i>{{ __('Download CV') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fun-fact-boxes mt-90 round15 position-relative w-100">
                                            <div class="row mrg">
                                                <div class="col-md-6 col-sm-6 col-lg-3 wow fadeIn" data-wow-duration="1s"
                                                    data-wow-delay=".2s">
                                                    <div
                                                        class="fun-fact-box d-flex flex-column align-items-start position-relative w-100">
                                                        <span>{{ __('Born In') }}</span>
                                                        <h3 class="mb-0 fw-normal sz-30">Locust, USA</h3>
                                                    </div><!-- Fun Fact Box -->
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-lg-3 wow fadeIn" data-wow-duration="1s"
                                                    data-wow-delay=".4s">
                                                    <div
                                                        class="fun-fact-box d-flex flex-column align-items-start position-relative w-100">
                                                        <span>{{ __('Experience') }}</span>
                                                        <h3 class="mb-0 fw-normal sz-30">5+ {{ __('Years') }}</h3>
                                                    </div><!-- Fun Fact Box -->
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-lg-3 wow fadeIn" data-wow-duration="1s"
                                                    data-wow-delay=".6s">
                                                    <div
                                                        class="fun-fact-box d-flex flex-column align-items-start position-relative w-100">
                                                        <span>{{ __('Worldwide Client') }}</span>
                                                        <h3 class="mb-0 fw-normal sz-30">1.3k</h3>
                                                    </div><!-- Fun Fact Box -->
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-lg-3 wow fadeIn" data-wow-duration="1s"
                                                    data-wow-delay=".8s">
                                                    <div
                                                        class="fun-fact-box d-flex flex-column align-items-start position-relative w-100">
                                                        <span>{{ __('Job Done Successfully') }}</span>
                                                        <h3 class="mb-0 fw-normal sz-30">4.9k</h3>
                                                    </div><!-- Fun Fact Box -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="position-relative pt-140 w-100">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-lg-5">
                                            <div class="sec-title-wrap mb-50 d-flex flex-column align-items-start position-relative w-100 wow fadeInUp"
                                                data-wow-duration=".5s" data-wow-delay=".2s">
                                                <div class="sec-title d-flex flex-column align-items-start w-100">
                                                    <span
                                                        class="sec-sub rounded-pill text-center">{{ __('About Me') }}</span>
                                                    <h2 class="mb-0 sz-40">
                                                        {{ __('I Have Rich Experience In Web Site Design') }}
                                                    </h2>
                                                </div><!-- Sec Title -->
                                                @if (isset($settings['cv_url']))
                                                    <a class="simple-link wow fadeInUp" data-wow-duration=".5s"
                                                        data-wow-delay=".4s" href="{{ $settings['cv_url'] }}"
                                                        title="" download><i
                                                            class="fas fa-arrow-alt-to-bottom round5"></i>{{ __('Download CV') }}
                                                    </a>
                                                @else
                                                    <a class="simple-link wow fadeInUp" data-wow-duration=".5s"
                                                        data-wow-delay=".4s" href="javascript:void(0);" title=""><i
                                                            class="fas fa-arrow-alt-to-bottom round5"></i>{{ __('Download CV') }}
                                                    </a>
                                                @endif
                                            </div><!-- Sec Title Wrap -->
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-7">
                                            <div class="about-cap d-flex flex-column position-relative w-100">
                                                <div class="about-img round15 overflow-hidden position-relative w-100 wow fadeIn"
                                                    data-wow-duration="1s" data-wow-delay=".5s">
                                                    <img class="img-fluid w-100" src="assets/images/resources/about-img.jpg"
                                                        alt="{{ __('About Image') }}" loading="lazy">
                                                    <a class="position-absolute sz-60"
                                                        href="https://www.youtube.com/embed/peiPQzRIxpI?si=anW1E2xiT9J98Xb5"
                                                        data-fancybox title=""><i class="fas fa-play-circle"></i></a>
                                                </div><!-- About Image -->
                                                <p class="mb-0">
                                                    {{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nisi, augue urna, mauris elementum ligula semper enim. Tristique sed sit facilisis ultrices rhoncus eget ullamcorper tellus. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendi.') }}
                                                </p>
                                                <p class="mb-0">
                                                    {{ __('Srepellat volup tatibus maiores aliasta consequatur auto perferendis repellat quia voluptas sit upto aspernatur te natus accusan.') }}
                                                </p>
                                            </div><!-- About Cap -->
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="projects">
                                <div class="position-relative pt-110 w-100">
                                    <div class="sec-title-wrap mb-50 text-center">
                                        <div class="sec-title">
                                            <span class="sec-sub rounded-pill text-center">{{ __('Projects') }}</span>
                                            <h2 class="mt-4 sz-40">{{ __('My Recent Projects') }}</h2>
                                        </div>
                                    </div>
                                    <div class="port-wrap position-relative w-100">
                                        <div class="row g-4">
                                            @foreach ($projects as $project)
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="port-box d-flex flex-column align-items-start w-100">
                                                        <div
                                                            class="port-img round15 overflow-hidden position-relative w-100">
                                                            <a href="javascript:void(0);">
                                                                <img class="img-fluid w-100"
                                                                    src="{{ asset('frontend/assets/images/resources/user-img.png') }}"
                                                                    alt="{{ __('Placeholder Image') }}" loading="lazy">
                                                            </a>
                                                            <div
                                                                class="port-cat d-flex align-items-center position-absolute">
                                                                @foreach ($project->technologies as $tech)
                                                                    <a href="javascript:void(0);"
                                                                        title="">{{ $tech->name_en ?? '' }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="port-info d-flex flex-column align-items-start w-100">
                                                            <a class="port-read rounded-circle"
                                                                href="{{ route('projects.show', $project->slug) }}">
                                                                <i class="far fa-long-arrow-right"></i></a>
                                                            <h4 class="mb-0 fw-normal sz-26"><a
                                                                    href="{{ route('projects.show', $project->slug) }}"
                                                                    title="">{{ $project->title_en }}</a></h4>
                                                            <span>{{ $project->category?->name_en }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>


                            {{-- ************ SKILLS ************ --}}
                            <section id="skills">
                                <div class="position-relative pt-120 w-100">
                                    <div
                                        class="sec-title-wrap mb-50 d-flex flex-column align-items-center text-center w-100">
                                        <div class="sec-title d-flex flex-column align-items-center w-100">
                                            <span class="sec-sub rounded-pill text-center">{{ __('My Skills') }}</span>
                                            <h2 class="mb-0 sz-40">{{ __('My Advantages') }}</h2>
                                        </div>
                                    </div>
                                    <div class="skill-boxes position-relative w-100">
                                        <div class="row justify-content-center mrg20">
                                            @foreach ($skills as $skill)
                                                <div class="col-md-4 col-sm-6 col-lg-3">
                                                    <div
                                                        class="skill-box round15 overflow-hidden position-relative text-center w-100">
                                                        <div class="skill-img overflow-hidden position-relative w-100 p-3">
                                                            <img class="img-fluid"
                                                                src="{{ asset($skill->icon ?? 'frontend/assets/images/placeholder.png') }}"
                                                                alt="{{ $skill->name ?? $skill->name_en }}"
                                                                loading="lazy">
                                                        </div>
                                                        <div
                                                            class="skill-info d-flex flex-column align-items-center w-100 py-2">
                                                            <h3 class="mb-0 fw-normal sz-36">{{ $skill->level ?? 100 }}%
                                                            </h3>
                                                            <h4 class="mb-0 sz-20">{{ $skill->name ?? $skill->name_en }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="position-relative pt-110 w-100">
                                    <div class="hire-head-box position-relative w-100">
                                        <h2
                                            class="mb-0 sz-90 fw-bolder text-white cont-opc5 scroll-h-anime position-absolute"
                                            data-text="Laravel. PHP. VueJS. jQuery. React. Tailwind. Bootstrap. Laravel. PHP. VueJS. jQuery. React. Tailwind. Bootstrap."
                                        >
                                            Laravel. PHP. VueJS. jQuery. React. Tailwind. Bootstrap.
                                        </h2>
                                    </div><!-- Hire Head Line Box -->
                                </div>
                            </section>
                            {{-- ************ EDUCATION & EXPERIENCE ************ --}}
                            <section id="resume">
                                <div class="position-relative pt-110 w-100">
                                    <div class="edu-exp-wrap position-relative w-100">
                                        <div class="row mrg40">

                                            <div class="col-lg-6">
                                                <div class="sec-title-wrap mb-50">
                                                    <div class="sec-title">
                                                        <span
                                                            class="sec-sub rounded-pill text-center">{{ __('Knowledge') }}</span>
                                                        <h2 class="mt-4 sz-40">{{ __('My Education') }}</h2>
                                                    </div>
                                                </div>
                                                <div class="edu-boxes d-flex flex-column w-100">
                                                    @foreach ($education as $edu)
                                                        <div
                                                            class="edu-box round15 d-flex flex-column position-relative w-100 p-3">
                                                            <h4 class="mb-0 fw-normal sz-24">
                                                                {{ $edu->degree ?? $edu->degree_en }}</h4>
                                                            <p class="mb-0">
                                                                {{ $edu->institution ?? $edu->institution_en }}</p>
                                                            <span>{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }}
                                                                -
                                                                {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : __('Present') }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="sec-title-wrap mb-50">
                                                    <div class="sec-title">
                                                        <span
                                                            class="sec-sub rounded-pill text-center">{{ __('Resume') }}</span>
                                                        <h2 style="margin-top: 26px;" class="mt-4 sz-40">
                                                            {{ __('My Experience') }}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="exp-boxes d-flex flex-column w-100">
                                                    @foreach ($experiences as $exp)
                                                        <div
                                                            class="exp-box round15 d-flex flex-column position-relative w-100 p-3">
                                                            <h4 class="mb-0 fw-normal sz-24 position-relative">
                                                                {{ $exp->position ?? $exp->position_en }}</h4>
                                                            <p class="mb-0">{{ $exp->company ?? $exp->company_en }}</p>
                                                            <span>{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }}
                                                                -
                                                                {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : __('Present') }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            {{-- ************ SERVICES ************ --}}
                            <section id="services">
                                <div class="position-relative pt-100 w-100">
                                    <div
                                        class="sec-title-wrap mb-50 d-flex flex-column align-items-center text-center w-100">
                                        <div class="sec-title d-flex flex-column align-items-center w-100">
                                            <span class="sec-sub rounded-pill text-center">{{ __('Services') }}</span>
                                            <h2 class="mb-0 sz-40">{{ __('My Specializations') }}</h2>
                                        </div>
                                    </div>
                                    <div class="serv-boxes position-relative w-100">
                                        <div class="row mrg40">
                                            @forelse($services as $index=>$service)
                                                <div class="col-md-6 col-sm-6 col-lg-4">
                                                    <div
                                                        class="serv-box round15 d-flex flex-column position-relative w-100 h-100">
                                                        <a class="serv-read rounded-circle"
                                                            href="{{ route('services.show', $service->slug) }}"
                                                            title=""><i class="far {{ app()->getLocale() == 'ar' ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i></a>
                                                        <h3 class="mb-0 fw-normal sz-30"><a
                                                                href="{{ route('services.show', $service->slug) }}"
                                                                title="">{!! nl2br(e($service->title ?? '')) !!}</a></h3>
                                                        <p class="mb-0">
                                                            {{ Str::limit($service->description ?? '', 60) }}
                                                        </p>
                                                        <span>{{ number_format($service->price, 2) }}
                                                            {{ $service->currency }}</span>
                                                    </div>
                                                </div>
                                            @empty
                                                <p>{{ __('No services added yet.') }}</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </section>


                            {{-- ************ BLOGS ************ --}}
                            {{-- <section id="blogs">
                                <div class="position-relative pt-110 w-100">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="sec-title-wrap mb-20">
                                                <div class="sec-title">
                                                    <span
                                                        class="sec-sub rounded-pill text-center">{{ __('My Blogs') }}</span>
                                                    <h2 class="mt-4 sz-40">{{ __('Recent Blogs & Articles') }}</h2>
                                                </div>
                                            </div>
                                            <div class="view-all mb-50">
                                                <p class="mb-0">
                                                    {{ __('Want to see my recent activities? Click here to') }} <a
                                                        href="" title="">{{ __('View More Posts') }}</a></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="post-boxes position-relative w-100">
                                                @foreach ($blogs as $blog)
                                                    <div class="post-box list d-flex position-relative w-100 mb-4">
                                                        <div class="post-img round15 overflow-hidden position-relative me-3"
                                                            style="max-width:200px">
                                                            <a href=""
                                                                title="{{ $blog->title ?? $blog->title_en }}">
                                                                <img class="img-fluid w-100"
                                                                    src="{{ asset($blog->cover_image ?? 'frontend/assets/images/placeholder.png') }}"
                                                                    alt="{{ $blog->title ?? $blog->title_en }}"
                                                                    loading="lazy">
                                                            </a>
                                                        </div>
                                                        <div class="post-info d-flex flex-column align-items-start">
                                                            <i
                                                                class="small text-muted">{{ $blog->created_at->format('d M, Y') }}</i>
                                                            <h4 class="mb-0 fw-normal sz-24"><a href=""
                                                                    title="">{{ $blog->title ?? $blog->title_en }}</a>
                                                            </h4>
                                                            <span>
                                                                @if (isset($blog->tags) && $blog->tags->count() > 0)
                                                                    @foreach ($blog->tags as $tag)
                                                                        <a href="javascript:void(0);"
                                                                            title="">{{ $tag->name ?? $tag->name_en }}</a>{{ !$loop->last ? ',' : '' }}
                                                                    @endforeach
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section> --}}

                            {{-- ************ TESTIMONIALS ************ --}}
                            <section id="testimonials">
                                <div class="position-relative pt-110 w-100">
                                    <div class="sec-title-wrap mb-50 text-center">
                                        <div class="sec-title">
                                            <span class="sec-sub rounded-pill text-center">{{ __('Testimonials') }}</span>
                                            <h2 class="mt-4 sz-40">{{ __('What Clients Say') }}</h2>
                                        </div>
                                    </div>
                                    <div class="testimonial-wrap position-relative w-100">
                                        <div class="row g-4">
                                            @foreach ($testimonials as $testimonial)
                                                <div class="col-lg-6">
                                                    <div class="testimonial-box d-flex flex-column p-4 round15">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="testimonial-img round-circle overflow-hidden me-3">
                                                                <img src="{{ asset($testimonial->image ?? 'frontend/assets/images/placeholder.png') }}"
                                                                    alt="{{ $testimonial->name }}" class="img-fluid"
                                                                    width="60" height="60">
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">{{ $testimonial->name }}</h5>
                                                                <p class="small mb-0">{{ $testimonial->role }}</p>
                                                                <div class="rating">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $testimonial->rating)
                                                                            <i class="fas fa-star text-warning"></i>
                                                                        @else
                                                                            <i class="far fa-star text-muted"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0">{{ $testimonial->message ?? '' }}</p>
                                                        <small class="text-muted mt-2">
                                                            {{ \Carbon\Carbon::parse($testimonial->date_given)->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>

                            {{-- ************ CERTIFICATES ************ --}}
                            <section id="certificates">
                                <div class="position-relative pt-110 w-100">
                                    <div class="sec-title-wrap mb-50 text-center">
                                        <div class="sec-title">
                                            <span
                                                class="sec-sub rounded-pill text-center">{{ __('Certifications') }}</span>
                                            <h2 class="mt-4 sz-40">{{ __('Professional Certifications') }}</h2>
                                        </div>
                                    </div>
                                    <div class="certificate-wrap position-relative w-100">
                                        <div class="row g-4">
                                            @foreach ($certificates as $certificate)
                                                <div class="col-md-6">
                                                    <div class="certificate-box d-flex flex-column p-4 round15">
                                                        <i class="cert-icon fas fa-award"></i>
                                                        <div class="certificate-content">
                                                            <span
                                                                class="issuer-badge">{{ $certificate->issued_by }}</span>
                                                            <h4 class="mb-2">{{ $certificate->title }}</h4>
                                                            <p class="mb-1"><strong>{{ __('Issued By:') }}</strong>
                                                                {{ $certificate->issued_by }}</p>
                                                            <p class="mb-1"><strong>{{ __('Date:') }}</strong>
                                                                {{ \Carbon\Carbon::parse($certificate->date_issued)->format('M Y') }}
                                                            </p>
                                                            @if ($certificate->expiry_date)
                                                                <p class="mb-3">
                                                                    <strong>{{ __('Valid Until:') }}</strong>
                                                                    {{ \Carbon\Carbon::parse($certificate->expiry_date)->format('M Y') }}
                                                                </p>
                                                            @endif
                                                            @if ($certificate->description)
                                                                <p class="mb-3">
                                                                    {{ Str::limit($certificate->description, 100) }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="certificate-footer mt-auto">
                                                            @if ($certificate->file_path)
                                                                <a href="{{ asset($certificate->file_path) }}"
                                                                    class="btn"
                                                                    target="_blank">{{ __('View Certificate') }} <i
                                                                        class="far fa-external-link"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>

                            {{-- ************ CONTACT ************ --}}
                     @include('frontend.common.contact-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
