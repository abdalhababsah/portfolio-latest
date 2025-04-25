<aside class="resume-sidebar d-flex flex-column position-sticky">
    <div class="theiaStickySidebar">
        <div class="resume-info round50 d-flex flex-column position-relative w-100">
            <div class="user-img round40 overflow-hidden position-relative w-100">
                <img class="img-fluid w-100"
                    src="{{ asset('frontend/assets/images/my-image.jpeg') }}"
                    alt="{{ __('User Image') }}" loading="lazy">
            </div>
            <div class="user-info d-flex flex-column align-items-start w-100">
                <a href="mailto:{{ $settings['contact_email'] ?? 'email@example.com' }}"
                    title="">{{ $settings['contact_email'] ?? 'contact@site.com' }}</a>
                <span>{{ $settings['base_location'] ?? __('Jordan') }}</span>
                <p class="mb-0">&copy; {{ date('Y') }} <a href="{{ url('/') }}"
                        title="">{{ $settings['site_title'] ?? 'Abdelrahman Portfolio' }}</a>.
                    {{ __('All Rights Reserved') }}</p>
            </div>
            <div
                class="user-social-wrap d-flex align-items-center justify-content-between position-relative w-100">
                <span>{{ __('Follow Me:') }}</span>
                <div class="social-links d-flex align-items-center gap-1">
                    @foreach ($socialLinks as $social)
                        <a href="{{ $social->url }}" title="{{ $social->platform }}"
                            target="_blank"><i class="fab {{ $social->icon_class }}"></i></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</aside>